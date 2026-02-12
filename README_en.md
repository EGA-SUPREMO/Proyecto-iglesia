# Parish Management System (PMS)
> **Note to Reader:** This project was developed as a Capstone for a T.S.U. in Computer Science (2025-2026), serving the San Diego de Alcalá and Candelaria parish house.

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

* **PDF Certificate Engine:** implementation using the library [PHPWord](https://github.com/PHPOffice/PHPWord) and OpenOffice to generate legal-ready certificates instantly.
* **Formatting Consistency:** Eliminates human error associated with manual Word document editing.

#### 3. Business Logic & Validation

* **Conflict Detection:** Custom server-side validation for the "Prayer Intentions" module prevents duplicate requests for specific Mass dates.
* **Schedule Management:** Full CRUD capabilities allow the secretary to manage liturgical schedules dynamically.

#### 4. System Reliability & DevOps

* **Automated Backups:** A custom script executes daily SQL dumps and synchronizes them to **Google Drive**, ensuring disaster recovery and data persistence.
* **Self-Diagnostic Module:** Includes a built-in "System Health Check" that verifies server configuration upon deployment. It checks:
* Required PHP extensions (ZIP, XML).
* OpenOffice installation and headless accessibility.
* Directory write permissions.



---

### 🛠️ Technical Stack

* **Backend:** PHP (Native/MVC approach)
* **Database:** MySQL (Relational Design, 15 Tables)
* **Frontend:** HTML5, CSS3, JavaScript (Vanilla + AJAX for async operations)
* **Methodology:** Extreme Programming (XP) - Iterative development with continuous feedback from the Parish Priest and Secretary.
* **External Tools:** OpenOffice (Headless mode for document conversion), Google Drive API (for backups).

### 🗄️ Database Architecture

The system utilizes a normalize relational database comprising **15 tables** to handle complex relationships between parishioners, sacraments, and events.

*(Optional: If you have an Entity-Relationship Diagram (ERD) image, put it here. Employers love seeing DB structure).*

---

### 🚀 Installation & Setup

**Prerequisites:**

* PHP 7.4 or higher
* MySQL 5.7+
* OpenOffice (for PDF generation features)

**Steps:**

1. Clone the repository:
```bash
git clone https://github.com/yourusername/parish-management-system.git

```


2. Import the database schema:
* Import `database.sql` into your MySQL server.


3. Configure environment variables:
* Rename `config.example.php` to `config.php` and update DB credentials.


4. **Run the System Check:**
* Navigate to `/install/check.php` (or wherever your testing module is).
* Ensure all status lights are green (Libraries, Permissions, OpenOffice).



---

### 🎓 Academic Context

This project was conducted as a descriptive research project under the modality of a special project.

* **Objective:** Optimize execution and delivery of services for the San Diego de Alcalá parish.
* **Methodology:** Extreme Programming (XP).
* **Data Collection:** Census-based sample using Likert-scale surveys to identify management flaws and validate the software solution.

### 👤 Author

**[Your Name]**

* **Portfolio:** [Link to your portfolio site]
* **LinkedIn:** [Link to your LinkedIn]
* **Email:** [Your Email]

---

### 💡 Why this structure works for you:

1. **The "System Health Check":** I highlighted the "module meant for internal testing" as a major feature called "Self-Diagnostic Module." This shows employers you think about **deployment** and **maintenance**, not just writing code.
2. **The Resume Mapping:** I took the "15-table relational database" and "Google Drive backup" points and gave them their own sections. These are high-value technical skills that separate you from entry-level developers.
3. **Academic vs. Professional:** I moved the academic abstract to the bottom. While impressive for your degree, a freelance client cares more about the "Features" and "Screenshots" than the "Likert-scale methodology."
4. **OpenOffice:** I emphasized the OpenOffice integration. Connecting PHP to external software (like OpenOffice) demonstrates the ability to handle complex server-side integrations.

**Would you like me to help you write the specific SQL description for the "Database Architecture" section, or perhaps help draft the code snippet for the "System Health Check" to make it look impressive in the repo?** 
