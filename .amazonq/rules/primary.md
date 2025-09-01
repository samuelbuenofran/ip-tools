## Amazon Q - Project Guidelines & Coding Standards

Analyze all code and provide all responses based on these rules. The primary goal is to generate secure, efficient, modern, and maintainable code.

## 1. Core Technology Stack

    Backend Language: PHP 8.1+

        Focus on modern PHP features and avoid deprecated functions.

    Database: MySQL 8.0+

        Ensure all queries are compatible with this version.

    Server OS: CentOS Linux

    Control Panel: DirectAdmin

    Frontend:

        HTML: HTML5

        CSS: CSS3

        CSS Framework: Bootstrap 5.3+

        JavaScript: ECMAScript 6 (ES6)+

        JS Library: jQuery 3.x (for legacy support and AJAX).

    JavaScript Preference: IMPORTANT: When possible, provide solutions in modern, vanilla JavaScript (ES6+). Only use jQuery if specifically asked or for simplifying complex AJAX calls.

## 2. Security First (Non-Negotiable)

    Critical: ALL database queries MUST use prepared statements (PDO or MySQLi) to prevent SQL injection. Never suggest concatenating variables directly into SQL strings.

    Critical: ALL user-provided output rendered in HTML MUST be escaped using htmlspecialchars() or a similar function to prevent Cross-Site Scripting (XSS).

    High Priority: Implement proper server-side file upload validation, checking for MIME type, file size, and using safe file naming conventions.

    High Priority: Use password_hash() and password_verify() for all password management. Never suggest using outdated hashing algorithms like MD5 or SHA1.

## 3. PHP Coding Standards

    Style: Follow the PSR-12 coding style for all generated PHP code (PascalCase for classes, camelCase for methods).

    Error Handling: Use declare(strict_types=1); at the top of PHP files. Use modern try-catch blocks for error handling, especially for database connections and critical operations.

    Documentation: Generate PHPDoc blocks for all functions and methods, explaining the purpose, parameters (@param), and return value (@return).

## 4. MySQL & Database Standards

    Naming Convention: Use snake_case for all table and column names (e.g., user_accounts, first_name).

    Engine: Default to the InnoDB storage engine to ensure support for transactions and foreign key constraints.

    Optimization: When suggesting queries, consider performance. If a WHERE clause is used on a large table, recommend indexing the relevant columns.

## 5. Frontend Development Standards

    HTML: Write semantic HTML5. Use tags like <header>, <nav>, <main>, <section>, <article>, and <footer> appropriately. Ensure all images have descriptive alt attributes for accessibility.

    CSS: Prioritize modern CSS layouts with Flexbox and Grid. Use CSS variables for colors and common spacing to promote maintainability.

    Bootstrap: Utilize the Bootstrap grid system (container, row, col-*) for layouts. Use Bootstrap utility classes for spacing, colors, and alignment wherever possible instead of writing custom CSS.

    JavaScript: Write modular and non-blocking JavaScript. Use const and let instead of var. For AJAX, provide examples using the modern fetch() API with async/await syntax.

## 6. Response Formatting

    Explanation First: Always provide a clear and concise explanation of the solution. Describe why the code works and what problem it solves.

    Complete Code Blocks: Provide complete, copy-paste-ready code blocks with language-specific highlighting.

    Alternatives: If there are multiple valid ways to solve a problem, briefly mention the alternatives and explain your chosen approach.