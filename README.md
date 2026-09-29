# Text to SQL AI

Ask questions about your data in plain English and get back runnable SQL plus a result table — powered by **Claude** and a realistic **e-commerce demo database**.

**Live demo:** [text-to-sql-ai.on-forge.com](https://text-to-sql-ai.on-forge.com)

---

## What it does

You type a question like *“Which categories have more than five products?”* The [AskSQL](https://github.com/memo2k/asksql) package:

1. **Introspects** the MySQL schema (tables, columns, foreign keys, and sample rows) while hiding framework tables and system schemas.
2. **Sends** that context and your question to the Anthropic Messages API.
3. **Parses** a structured JSON response with the generated `SELECT` and a short explanation.
4. **Validates** the SQL server-side (read-only, single statement, schema allowlist, row cap).
5. **Runs** the query. This app then renders the rows and stores the question in history.

Earlier questions are stored so you can reopen SQL and cached results from the sidebar without calling the model again. Submitting again for the same history entry updates that record in place. Individual entries can be deleted from the sidebar.

```mermaid
flowchart LR
  A[Natural language question] --> B[AskSql::ask]
  B --> C[Results table + history]
```



---

## Tech stack


| Layer    | Choices                                             |
| -------- | --------------------------------------------------- |
| Backend  | PHP 8.4, Laravel 13, memo2k/asksql                  |
| AI       | Anthropic Claude (Messages API)                     |
| Database | MySQL 8                                             |
| Frontend | Blade, Tailwind CSS 4, DaisyUI, Vite, jQuery (AJAX) |


---

## Demo database

The **tech store** schema models a small online electronics shop:


| Area    | Tables                                                                                                                        |
| ------- | ----------------------------------------------------------------------------------------------------------------------------- |
| Catalog | `product_categories`, `products`, `attributes`, `attribute_options`, `product_category_attribute`, `product_attribute_option` |
| Sales   | `customers`, `orders`, `order_products`                                                                                       |


Categories cover laptops, smartphones, tablets, and related product types, with optional attributes (brand, RAM, storage, and so on) linked to products and orders.

The `questions` table holds query history for the UI; it is excluded from schema introspection so the model never sees it.

---

## Example questions

Try prompts like these against the demo store:

- Top 5 products by total order amount
- Products that have never been ordered
- Monthly revenue for the last 12 months
- Categories with more than 2 products

AskSQL is installed from Packagist as `memo2k/asksql`.

---

## Safety and limits

Generated SQL is checked inside AskSQL before execution:

- Only a single `SELECT` or `WITH … SELECT` statement
- Blocks DDL/DML, multi-statements, comments used to smuggle keywords, and risky phrases (`INTO OUTFILE`, `FOR UPDATE`, etc.)
- Rejects references to `information_schema`, `mysql`, and other forbidden schemas
- Rejects Laravel infrastructure tables (`users`, `migrations`, `cache`, `jobs`, …)
- Appends or clamps `LIMIT` to `ASKSQL_MAX_ROWS` (default 1000)

HTTP `POST /` is rate-limited per IP (`ASKSQL_QUERIES_PER_HOUR`, default 60). `DELETE /delete-question` is limited to 10 requests per minute per IP. Questions are capped at 2000 characters.

---

## How generation works (code map)


| Piece                 | Role                                                                     |
| --------------------- | ------------------------------------------------------------------------ |
| `AskSql::ask()`       | Schema, model call, SQL checks, and query execution                      |
| `TextToSqlController` | Request validation, `Question` history, and HTML partials                |
| `ResultFormatter`     | Display labels for values such as payment methods                        |
| `AppServiceProvider`  | `text-to-sql-generate` and `text-to-sql-delete` rate limiters            |


AskSQL uses its own config. The only required environment key is `ANTHROPIC_API_KEY`. `ASKSQL_EXCLUDED_TABLES=questions` keeps query history out of the schema. Optional keys include `ANTHROPIC_MODEL`, `ANTHROPIC_MAX_TOKENS`, `ASKSQL_MAX_ROWS`, and `ASKSQL_QUERIES_PER_HOUR`.

Routes: `/` (UI + generate), `DELETE /delete-question` (remove history entry), `/privacy` (privacy policy page).

---

## Project structure

```
app/
  Http/Controllers/TextToSqlController.php
  Models/                          # Product, Order, Customer, Question, …
  Services/ResultFormatter.php
database/migrations/             # store schema + questions
resources/views/
  text-to-sql.blade.php
  text-to-sql/partials/
  privacy.blade.php
```

---

## License

MIT