# Excel Import & Validate Data

A modern web application for importing, validating, and visualizing Excel data with row-level error reporting. Built with Laravel (backend) and Next.js (frontend), styled with Tailwind CSS, and featuring a beautiful, animated UI.

---

## Features
- Upload Excel files via a drag-and-drop interface
- Row-by-row validation (required fields, email, integer, etc.)
- Displays errors per row/column in a modern, scrollable table
- Saves valid rows, skips invalid ones
- Downloadable Excel file with failed rows and error messages
- Animated summary chart and responsive, professional UI

---

## Tech Stack
- **Backend:** Laravel + [Maatwebsite/Laravel-Excel](https://laravel-excel.com/)
- **Frontend:** Next.js (App Router) + React + Tailwind CSS
- **Excel Upload:** react-dropzone, axios
- **Charts:** react-chartjs-2, chart.js

---

## Setup Instructions

### 1. Backend (Laravel)
```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate # (if using database)
composer require maatwebsite/excel
php artisan storage:link
php artisan serve
```

### 2. Frontend (Next.js)
```bash
cd frontend
npm install
npm install axios react-dropzone react-chartjs-2 chart.js
npm run dev
```

---

## Usage
1. Start both backend (`php artisan serve`) and frontend (`npm run dev`).
2. Open the frontend in your browser (usually [http://localhost:3000](http://localhost:3000)).
3. Drag & drop or select an Excel file with columns: `name`, `email`, `age`.
4. View animated summary, error table, and download failed rows if needed.

---

## Excel File Format
| name    | email            | age |
|---------|------------------|-----|
| John    | john@email.com   | 25  |
| Jane    | jane@email.com   | 30  |
| Bob     | bob@email.com    |     |
| Invalid | invalid-email.com| -5  |

---

## Screenshots

![Screenshot 1](screenshot/1.png)
![Screenshot 2](screenshot/2.png)

---

## License
MIT 
