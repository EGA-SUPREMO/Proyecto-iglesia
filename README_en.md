# Parish Management System (PMS)
> **Note to Reader:** This project was developed as a Capstone for a T.S.U. in Computer Science (2024-2026), serving the San Diego de Alcalá and Candelaria parish house.

### 📖 Overview

The **Parish Management System** is a full-stack web application designed to digitize and optimize the administrative workflows of a religious non-profit organization.

Prior to this system, the parish relied on physical books and manual Word documents, leading to data redundancy and slow processing times. This solution migrates 100% of the record-keeping to a digital environment, streamlining the issuance of sacraments (Baptism, Communion, Confirmation and Marriage) and managing daily prayer intentions.

### 📸 Screenshots

*(TODO Place a few screenshots here! Suggestions: The Dashboard, The "Prayer Intentions" form, and a generated PDF certificate. Visuals sell the code.)*

---

### Key Features

#### 1. Lifecycle Record Management

* **Centralized Database:** Migrated physical records to a relational database, tracking parishioner history from Baptism to Marriage.
* **Smart Auto-fill:** SQL queries retrieve existing data to populate new forms (e.g., pulling Baptism data when registering for First Communion), significantly reducing data entry time.

#### 2. Automated Document Generation

* **PDF Certificate Engine:** implementation using the library [PHPWord](https://github.com/PHPOffice/PHPWord) and [LibreOffice](https://www.libreoffice.org/) to generate legal-ready certificates instantly.
* **Formatting Consistency:** Eliminates human error associated with manual Word document editing.

#### 3. Business Logic & Validation

* **Conflict Detection:** Custom server-side validation for the "Prayer Intentions" module prevents duplicate requests for specific Mass dates.
* **Schedule Management:** Full CRUD capabilities allow the secretary to manage liturgical schedules dynamically.

#### 4. System Reliability & DevOps

* **Automated Backups:** A custom script executes daily SQL dumps and synchronizes them to **Google Drive**, ensuring disaster recovery and data persistence.
* **Self-Diagnostic Module:** Includes a built-in "System Health Check" that verifies server configuration upon deployment. It checks:
  * Required PHP extensions (ZIP, XML and INTL).
  * LibreOffice installation.
  * Directory write permissions.



---

### 🛠️ Technical Stack

* **Backend:** PHP (Native/MVC approach)
* **Database:** MySQL/MariaDB (Relational Design, 15 Tables)
* **Frontend:** HTML5, CSS3, JavaScript (JQuery + AJAX for async operations)
* **Methodology:** Extreme Programming (XP) - Iterative development with continuous feedback from the Parish Priest and Secretary.
* **External Tools:** LibreOffice (Headless mode for document conversion), Google Drive (for backups).

## Database Architecture

The system utilizes a **normalized relational schema (MySQL/MariaDB)** across 15 tables, optimized for strict data integrity and the automation of parish-specific business logic.

### Technical Implementation

* **Engine-Level Validation:** Extensive use of `CHECK` constraints prevents logical inconsistencies before they reach the application layer.
* `chk_roles_familiares_distintos`: Ensures the Baptized, Mother, and Father represent three unique records in the `constancia_de_fe_de_bautizo` table.
* `chk_cedula_partida_nacimiento`: Guarantees that every record in `feligreses` contains at least one valid form of identification (ID card or birth certificate).


* **Referential Integrity:** Foreign keys are configured with `ON DELETE CASCADE` for the `feligreses` table. This ensures that deleting a parishioner automatically prunes all associated sacramental history and petitions, preventing orphaned records.
* **Unified Transaction Hub:** The architecture employs a polymorphic-style approach in the `peticiones` table. It acts as a central ledger, dynamically linking service requests to specific sacrament records (`constancia_id`) or mass intentions (`misa_id`) based on the transaction type.

### 🧬 Entity Relationship Diagram (ERD)

*(TODO Entity-Relationship Diagram (ERD) image).*

---

### 🚀 Installation & Setup

**Prerequisites:**

* PHP 8.4 or higher
* MySQL 5.7+ or MariaDB
* LibreOffice (for PDF generation features)

**Steps:**

1. Clone the repository:
```bash
git clone https://github.com/EGA-SUPREMO/Sistema-de-Gestion-Parroquial.git

```


2. Import the database schema:
* Import `sql/gestion_parroquial_db.sql` into your MySQL/MariaDB server.


3. Configure environment variables:
* Rename `template.env` to `.env` and update DB credentials.


4. **Run the System Check:**
* Navigate to `/test_diagnostico.php`.
* Ensure all status lights are green (Libraries, Permissions, LibreOffice).



---

### 🎓 Academic Context

This project was conducted as a descriptive research project under the modality of a special project.

* **Objective:** Optimize execution and delivery of services for the San Diego de Alcalá parish.
* **Methodology:** Extreme Programming (XP).
* **Data Collection:** Census-based sample using Likert-scale surveys to identify management flaws and validate the software solution.

## License
This project is licensed under the [GNU General Public License (GPL) version 3](LICENSE)
