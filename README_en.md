# Parish Management System (PMS)
> **Note to Reader:** This project was developed as a Capstone for a T.S.U. in Computer Science (2024-2026), serving the San Diego de Alcalá and Candelaria parish house.

### 📖 Overview

The **Parish Management System** is a web application built to help the parish move from paper records to a digital workflow.

Prior to this system, the parish relied on physical books and manual Word documents, which was slow and often led to errors. This solution digitizes the entire process, making it easy to issue sacraments (Baptism, Communion, Confirmation, and Marriage) and manage daily prayer intentions.

### 📸 Screenshots
<img src="Documentacion/demo1.GIF" width="600">
<p align="left">
  <img src="Documentacion/agenda_screenshot.png" width="50%" />
</p>

<p align="center">
  <img src="Documentacion/dashboard_screenshot.png" width="50%" />
  <img src="Documentacion/example_certificate.png" width="50%" />
</p>

### Key Features

#### 1. Managing Parish Records

* **Centralized Database:** Tracks a parishioner's journey from Baptism to Marriage in one database, replacing scattered paper files.
* **Smart Auto-fill:** The system saves time by reusing existing data. For example, when registering for First Communion, it automatically pulls up the person's Baptism details so you don't have to type them again.
* **Data Safety:** TODO the checks and Uses `ON DELETE CASCADE` to ensure that if a parishioner is removed, all associated records are pruned to prevent orphaned data. while also giving appropite warning for this kind of operation

#### 2. Automated Document Generation

* **PDF Certificate Engine:** implementation using the library [PHPWord](https://github.com/PHPOffice/PHPWord) and [LibreOffice (Headless)](https://www.libreoffice.org/) to generate legal-ready certificates instantly.
* **No More Typos:** Because the system generates the document from the database, it eliminates the copy-paste errors common with manual Word files.
* **Editable Drafts:** If a manual change is needed, the user can download a `.docx` version instead of the final `.pdf`.

#### 3. Scheduling & Logic
* **Prevents double-booking:** The system checks dates automatically to ensure "Prayer Intentions" don't conflict.
* **Easy Management:** Allows the secretary to easily add, edit, or delete liturgical schedules.


#### 4. Reliability & Maintenance

* **Automatic Backups:** A script runs daily to save a copy of the database to a local folder. When paired with Google Drive or OneDrive, this ensures data is never lost.
* **Self-Diagnostic Module:** Includes a built-in "System Health Check" (`/test_diagnostico.php`) that verifies server configuration upon deployment. It checks:
  * Required PHP extensions (ZIP, XML and INTL).
  * LibreOffice installation and path visibility.
  * Directory write permissions.

#### 4. Reliability & Maintenance

* **System Health Check:** Includes a self-test page (`/test_diagnostico.php`) that checks if the server is ready (verifying PHP extensions, permissions, and LibreOffice status) to prevent deployment issues.

---

### 🛠️ Technical Stack

* **Backend:** PHP (Native/MVC approach)
* **Dependency Manager:** Composer
* **Database:** MySQL/MariaDB (15 Tables)
* **Frontend:** HTML5, CSS3, JavaScript (jQuery)
* **Methodology:** Extreme Programming (XP) - Iterative development with continuous feedback from the Parish Priest and Secretary.
* **External Tools:**
  * **LibreOffice:** Used in headless mode for `.docx` to `.pdf` conversion.
  * **PHPWord:** For template processing.

## Database Architecture

The system utilizes a **normalized relational schema (MySQL/MariaDB)** across 15 tables, optimized for strict data integrity and the automation of parish-specific business logic.

### How it Works
* **Strict Rules (Constraints):** We use SQL checks to stop bad data before it enters the system. A few examples are:
    * `chk_roles_familiares_distintos`: Ensures that the Child, Mother, and Father in a baptism record are three different people.
    * `chk_cedula_partida_nacimiento`: Guarantees that every parishioner has at least one valid ID (Identity Card or Birth Certificate).
* **Centralized Transactions:** The `peticiones` (petitions) table acts as a central hub. It links service requests to either a specific sacrament or a mass intention, keeping records organized.

### 🧬 Entity Relationship Diagram (ERD)

*(TODO Entity-Relationship Diagram (ERD) image).*

---

### 🚀 Installation & Setup

**Prerequisites:**
* **Server:** Apache
* **PHP:** Version 8.4+
* **Extensions:** Ensure `extension=zip`, `extension=intl`, and `extension=gd` are enabled in `php.ini`.
* **Database:** MySQL 5.7+ or MariaDB.
* **PDF Engine:** LibreOffice (Must be installed on the host machine).

**Steps:**

1. **Clone the repository:**
```bash
git clone https://github.com/EGA-SUPREMO/Sistema-de-Gestion-Parroquial.git

```

2.  **Install Dependencies:**
Navigate to the project folder and run:
```bash
composer install
```

3.  **Database Setup:**
    * Create a database named `gestion_parroquial_db`.
    * Import the file `sql/gestion_parroquial_db.sql`.

4.  **Configuration:**
    * Rename `template.env` to `.env` and update your database credentials.
    * Set `DB_DIR_BACKUP` to a valid path (preferably a cloud-synced folder).
 
    * **Windows Users:**
        * If using Windows 11, ensure template files in `public/plantillas/` are not "Blocked". (Right-click file -> Properties -> Unblock).
 
5.  **Run the System Check:**
    * Navigate to `http://localhost/test_diagnostico.php`.
    * Ensure all status lights are green (Libraries, Permissions, LibreOffice). If "LibreOffice" is red, PDF generation will fail (falling back to .docx).

---

### Academic Context

This project was conducted as a capstone project to obtain an Associate of Science (A.S.) in Computer Science.

* **Objective:** Optimize execution and delivery of services for the San Diego de Alcalá parish.
* **Methodology:** Extreme Programming (XP).
* **Data Collection:** Likert-scale surveys & census-based data analysis.

## License
This project is licensed under the [GNU General Public License (GPL) version 3](LICENSE)
