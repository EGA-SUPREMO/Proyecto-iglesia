# Parish Management System (PMS)
> **Note to Reader:** This project was developed as a Capstone for a T.S.U. in Computer Science (2024-2026), serving the San Diego de Alcalá and Candelaria parish house.

### 📖 Overview

The **Parish Management System** is a full-stack web application designed to digitize and optimize the administrative workflows of a religious non-profit organization.

Prior to this system, the parish relied on physical books and manual Word documents, leading to data redundancy and slow processing times. This solution migrates the record-keeping to a digital environment, streamlining the issuance of sacraments (Baptism, Communion, Confirmation and Marriage) and managing daily prayer intentions.

### 📸 Screenshots

*(TODO Place a few screenshots here! Suggestions: The Dashboard, The "Prayer Intentions" form, and a generated PDF certificate. Visuals sell the code.)*

---

### Key Features

#### 1. Lifecycle Record Management

* **Centralized Database:** Migrated physical records to a relational database, tracking parishioner history from Baptism to Marriage.
* **Smart Auto-fill:** SQL queries retrieve existing data to populate new forms (e.g., pulling Baptism data when registering for First Communion), significantly reducing data entry time.
* **Referential Integrity:** TODO the checks and Uses `ON DELETE CASCADE` to ensure that if a parishioner is removed, all associated records are pruned to prevent orphaned data. also give appropite warning for this kind of operation

#### 2. Automated Document Generation

* **PDF Certificate Engine:** implementation using the library [PHPWord](https://github.com/PHPOffice/PHPWord) and [LibreOffice (Headless)](https://www.libreoffice.org/) to generate legal-ready certificates instantly.
* **Formatting Consistency:** Eliminates human error associated with manual Word document editing.
* **Editable Drafts:** Includes a fallback feature where users can change the URL extension from `.pdf` to `.docx` to download a raw Word file for manual corrections if needed.

#### 3. Business Logic & Validation

* **Conflict Detection:** Custom server-side validation for the "Prayer Intentions" module prevents duplicate requests for specific Mass dates.
* **Schedule Management:** Full CRUD capabilities allow the secretary to manage liturgical schedules dynamically.

#### 4. System Reliability & DevOps

* **Disaster Recovery Strategy:** A custom script executes daily SQL dumps to a specific local directory (`DB_DIR_BACKUP`). When combined with a cloud sync client (Google Drive/OneDrive Desktop), this ensures off-site persistence.
* **Self-Diagnostic Module:** Includes a built-in "System Health Check" (`/test_diagnostico.php`) that verifies server configuration upon deployment. It checks:
  * Required PHP extensions (ZIP, XML and INTL).
  * LibreOffice installation and path visibility.
  * Directory write permissions.

---

### 🛠️ Technical Stack

* **Backend:** PHP (Native/MVC approach)
* **Dependency Management:** Composer
* **Database:** MySQL/MariaDB (Relational Design, 15 Tables)
* **Frontend:** HTML5, CSS3, JavaScript (jQuery + AJAX for async operations)
* **Methodology:** Extreme Programming (XP) - Iterative development with continuous feedback from the Parish Priest and Secretary.
* **External Tools:**
  * **LibreOffice:** Used in headless mode for `.docx` to `.pdf` conversion.
  * **PHPWord:** For template processing.


## Database Architecture

The system utilizes a **normalized relational schema (MySQL/MariaDB)** across 15 tables, optimized for strict data integrity and the automation of parish-specific business logic.

### Technical Implementation

* **Engine-Level Validation:** Extensive use of `CHECK` constraints prevents logical inconsistencies before they reach the application layer.
* Some examples are:
* `chk_roles_familiares_distintos`: Ensures the Baptized, Mother, and Father represent three unique records in the `constancia_de_fe_de_bautizo` table.
* `chk_cedula_partida_nacimiento`: Guarantees that every record in `feligreses` contains at least one valid form of identification (ID card or birth certificate).

* **Referential Integrity:** Foreign keys are configured with `ON DELETE CASCADE` for the `feligreses` table. This ensures that deleting a parishioner automatically prunes all associated sacramental history and petitions, preventing orphaned records.
* **Unified Transaction Hub:** The architecture employs a polymorphic-style approach in the `peticiones` table. It acts as a central ledger, dynamically linking service requests to specific sacrament records (`constancia_id`) or mass intentions (`misa_id`) based on the transaction type.

+* **Engine-Level Validation:** Extensive use of `CHECK` constraints prevents logical inconsistencies.
+    * `chk_roles_familiares_distintos`: Ensures the Baptized, Mother, and Father represent three unique records.
+    * `chk_cedula_partida_nacimiento`: Guarantees every parishioner has at least one valid ID.
+* **Unified Transaction Hub:** The architecture employs a polymorphic-style approach in the `peticiones` table. It acts as a central ledger, dynamically linking service requests to specific sacrament records or mass intentions.

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

1. Clone the repository:
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
    * Import `sql/gestion_parroquial_db.sql` into your MySQL/MariaDB server.

4.  **Environment Configuration:**
    * Rename `template.env` to `.env` and update DB credentials.
    * Set `DB_DIR_BACKUP` to a valid local path (preferably a Google Drive/OneDrive synced folder) for backups.
 
5.  **Windows Specific Configuration:**
    * If using Windows 11, ensure template files in `public/plantillas/` are not "Blocked". (Right-click file -> Properties -> Unblock).
 
6.  **Run the System Check:**
    * Navigate to `http://localhost/test_diagnostico.php`.
    * Ensure all status lights are green (Libraries, Permissions, LibreOffice). If "LibreOffice" is red, PDF generation will fail (falling back to .docx).

---

### 🎓 Academic Context

This project was conducted as a capstone project to obtain an Associate of Science (A.S.) in Computer Science.

* **Objective:** Optimize execution and delivery of services for the San Diego de Alcalá parish.
* **Methodology:** Extreme Programming (XP).
* **Data Collection:** Likert-scale surveys & census-based data analysis.

## License
This project is licensed under the [GNU General Public License (GPL) version 3](LICENSE)
