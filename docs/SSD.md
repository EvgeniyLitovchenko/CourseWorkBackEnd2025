# System Specification Document (SSD)
## Museum Management System - Technical Architecture

### 1. System Overview
The Museum Management System is a web-based application built using PHP with MVC (Model-View-Controller) architecture pattern. It provides a platform for managing museum exhibitions, news content, and visitor information with an administrative interface for content management.

**Technology Stack:**
- **Backend Framework**: Custom PHP MVC Framework
- **Database**: MySQL 5.7+
- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **Server**: Apache/PHP 7.4+

### 2. Architecture Overview

#### 2.1 Layered Architecture
```
┌─────────────────────────────────────────┐
│          Presentation Layer             │
│  (Views - HTML Templates)               │
└─────────────────────────────────────────┘
                    ↓
┌─────────────────────────────────────────┐
│          Business Logic Layer           │
│  (Controllers)                          │
└─────────────────────────────────────────┘
                    ↓
┌─────────────────────────────────────────┐
│          Data Access Layer              │
│  (Models, Database Class)               │
└─────────────────────────────────────────┘
                    ↓
┌─────────────────────────────────────────┐
│          Data Layer                     │
│  (MySQL Database)                       │
└─────────────────────────────────────────┘
```

#### 2.2 Directory Structure
```
CourseWorkBackEnd2025/
├── index.php                 # Application entry point
├── classes/                  # Core framework classes
│   ├── Core.php             # Main application class (routing, initialization)
│   ├── Controller.php       # Base controller class
│   ├── Model.php            # Base model class
│   ├── DB.php               # Database connection and query builder
│   ├── Template.php         # View rendering engine
│   ├── Request.php          # HTTP request handler
│   ├── Session.php          # Session management
│   ├── Config.php           # Configuration settings
├── config/                   # Configuration files
│   ├── config.php           # Application configuration
│   ├── database.php         # Database credentials
├── controllers/              # Application controllers
│   ├── SiteController.php   # Main site pages (About, Contacts, etc.)
│   ├── ExhibitionsController.php  # Exhibition management
│   ├── NewsController.php   # News management
│   ├── AdminController.php  # Admin panel
├── models/                   # Data models
│   ├── Exhibitions.php      # Exhibition model
│   ├── ExhibitionTypes.php  # Exhibition types model
│   ├── ExhibitionImages.php # Exhibition images model
│   ├── News.php             # News model
│   ├── Users.php            # User authentication
│   ├── Contacts.php         # Contact information
│   ├── Feedback.php         # User feedback
│   ├── VisitorInfo.php      # Visitor information
├── views/                    # View templates
│   ├── admin/               # Admin panel views
│   ├── Exhibitions/         # Exhibition views
│   ├── News/                # News views
│   ├── Site/                # Public site views
│   ├── shared/              # Shared components (pagination, etc.)
├── layout/                   # Layout templates
│   ├── light/               # Public site layout
│   ├── admin/               # Admin panel layout
├── public/                   # Static files
│   ├── css/                 # Stylesheets
│   ├── js/                  # JavaScript files
│   ├── images/              # Uploaded images
```

### 3. Core Components

#### 3.1 Routing System
The application uses a custom routing system based on URL pattern:
```
URL: /controller/action?params
Example: /exhibitions/show?type_id=1&page=0
```

**Routing Flow:**
1. User requests `/exhibitions/show?type_id=1&page=0`
2. `Core::run()` parses the route from `$_GET['route']`
3. Extracts controller name (Exhibitions) and action name (show)
4. Instantiates `ExhibitionsController` and calls `actionShow()`
5. Controller processes request and returns view

#### 3.2 Database Layer (DB Class)
Custom query builder providing:
- **SELECT queries**: `select($table, $fields, $where, $orderBy, $limit, $offset)`
- **INSERT queries**: `insert($table, $data)`
- **UPDATE queries**: `update($table, $data, $where)`
- **DELETE queries**: `delete($table, $where)`
- **Connection pooling**: PDO with persistent connections
- **Prepared statements**: Protection against SQL injection

**Example Usage:**
```php
$db = Core::getInstance()->db;
$exhibitions = $db->select('exhibitions', '*', 
    ['type_id' => 1], 'created_at DESC', 10, 0);
```

#### 3.3 Model Layer
Base Model class providing ORM-like functionality:
- **Attributes**: Dynamic property assignment
- **CRUD Operations**: `find()`, `findAll()`, `findById()`, `findByCondition()`
- **Data Persistence**: `save()` for insert/update
- **Relationships**: Foreign key management
- **Timestamps**: Automatic `created_at`, `updated_at` management

**Model Methods:**
```php
class Model {
    static function findAll($offset = 0, $limit = null)
    static function findById($id)
    static function findByCondition($where, $offset = 0, $limit = null, $orderBy = null)
    static function countAll()
    public function save()
    public function delete()
}
```

#### 3.4 Controller Layer
Base Controller providing:
- Request handling
- View rendering with template engine
- Data validation
- Error/Success message handling
- Redirect functionality
- Authentication checks

**Controller Methods:**
```php
class Controller {
    public function view($title, $data = [], $template_path = null)
    public function redirect($url)
    public function addErrorMessage($msg)
    public function addSuccessMessage($msg)
}
```

#### 3.5 View/Template Engine
Custom template renderer with:
- Variable interpolation
- HTML escaping for security
- Layout system
- Template inheritance

**Usage:**
```php
$template = new Template('views/Exhibitions/show.php');
$template->addParams(['exhibitions' => $data]);
echo $template->render();
```

### 4. Data Models

#### 4.1 Exhibitions Table
```sql
CREATE TABLE exhibitions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    type_id INT FOREIGN KEY REFERENCES exhibition_types(id),
    start_date DATE,
    end_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)
```

**Model Class**: `models/Exhibitions.php`
**Key Methods**:
- `getExhibitions()` - Get paginated exhibitions with filters
- `countExhibitions()` - Count total exhibitions
- `findById()` - Get exhibition by ID
- `save()` - Insert or update exhibition

#### 4.2 News Table
```sql
CREATE TABLE news (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    excerpt TEXT,
    content TEXT NOT NULL,
    image VARCHAR(255),
    published_at TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)
```

**Model Class**: `models/News.php`
**Key Methods**:
- `getNews()` - Get paginated news articles
- `countNews()` - Count total articles
- `findById()` - Get news by ID

#### 4.3 Exhibition Types Table
```sql
CREATE TABLE exhibition_types (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)
```

#### 4.4 Exhibition Images Table
```sql
CREATE TABLE exhibition_images (
    id INT PRIMARY KEY AUTO_INCREMENT,
    exhibition_id INT FOREIGN KEY REFERENCES exhibitions(id) ON DELETE CASCADE,
    image_path VARCHAR(255) NOT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)
```

#### 4.5 Users Table
```sql
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255),
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)
```

### 5. Authentication & Authorization

#### 5.1 Authentication Flow
1. Admin logs in with username/password
2. Credentials validated against `users` table
3. Session created with user ID and role
4. Session data stored in `$_SESSION`

#### 5.2 Authorization
- Method: Session-based role checking
- Check: `Users::isAdminLogin()` returns true/false
- Access Control: Controllers redirect to login if not authenticated

```php
if (!Users::isAdminLogin()) {
    $this->redirect('/admin/login');
}
```

### 6. API Endpoints

#### 6.1 Public Endpoints
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/site/main` | Homepage |
| GET | `/site/about` | About page |
| GET | `/site/contacts` | Contact information |
| GET | `/site/visitors` | Visitor guidelines |
| GET | `/exhibitions/show` | List exhibitions |
| GET | `/exhibitions/view/{id}` | Exhibition details |
| GET | `/news/show` | List news articles |
| GET | `/news/view/{id}` | News details |

#### 6.2 Admin Endpoints
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/admin/login` | Admin login page |
| POST | `/admin/login` | Process login |
| GET | `/admin/dashboard` | Admin dashboard |
| GET | `/admin/exhibitions` | Manage exhibitions |
| POST | `/admin/exhibition-create` | Create exhibition |
| POST | `/admin/exhibition-edit/{id}` | Edit exhibition |
| POST | `/admin/exhibition-delete/{id}` | Delete exhibition |
| GET | `/admin/news` | Manage news |
| POST | `/admin/news-create` | Create news |
| POST | `/admin/news-edit/{id}` | Edit news |

### 7. Request/Response Flow

#### 7.1 Exhibition List Request Flow
```
1. User Request: GET /exhibitions/show?type_id=1&page=0
2. Core::run() parses route and extracts:
   - Controller: ExhibitionsController
   - Action: show
   - Params: type_id=1, page=0
3. ExhibitionsController::actionShow($type_id=1, $page=0)
4. Business Logic:
   - Query exhibitions with filters
   - Calculate pagination
   - Get exhibition types for filter
5. Response: View rendered with data
6. Template: views/Exhibitions/view.php
```

#### 7.2 News Create Request Flow
```
1. Admin submits form to POST /admin/news-create
2. Request::post() extracts form data
3. Validation checks
4. News model created and saved
5. Image uploaded if provided
6. Redirect to /admin/news with success message
```

### 8. Security Measures

#### 8.1 Input Validation
- Form data validated before saving
- Type checking for numeric fields
- String trimming and filtering
- Required field validation

#### 8.2 SQL Injection Prevention
- Prepared statements via PDO
- Parameter binding in queries
- Parameterized WHERE clauses in ORM

#### 8.3 Session Security
- Session timeout: 30 minutes
- Session regeneration on login
- Secure session storage
- CSRF token implementation (future)

#### 8.4 File Upload Security
- File type validation (MIME type checking)
- File size limits (5MB maximum)
- Uploaded files stored outside webroot (future)
- Filename sanitization

### 9. Performance Considerations

#### 9.1 Database Optimization
- Indexed columns: `id`, `type_id`, `created_at`
- Query optimization with LIMIT and OFFSET
- Prepared statements reduce parsing overhead

#### 9.2 Caching Strategy
- HTTP caching headers for static files
- Database query result caching (future)
- Template caching (future)

#### 9.3 Load Optimization
- Lazy loading of exhibition images
- Pagination limits to 6-10 items per page
- Image compression and resizing

### 10. Error Handling

#### 10.1 Exception Handling
- Database exceptions caught and logged
- User-friendly error messages displayed
- 404 handling for non-existent pages
- Error logging to file system

#### 10.2 Validation Errors
- Form validation with error collection
- Error messages passed to view
- User feedback on validation failures

### 11. Configuration Management

#### 11.1 Environment Configuration
Located in `config/config.php` and `config/database.php`:
```php
- Database host
- Database name
- Database user/password
- Application timezone
- Site URL
- Admin email
```

### 12. Deployment Architecture

#### 12.1 Deployment Stack
```
┌─────────────────────────┐
│   Client Browser        │
└────────────┬────────────┘
             │ HTTP/HTTPS
┌────────────v────────────┐
│   Web Server (Apache)   │
│   PHP 7.4+              │
└────────────┬────────────┘
             │
┌────────────v────────────┐
│   MySQL Database        │
│   5.7+                  │
└─────────────────────────┘
             │
         (Files)
┌────────────v────────────┐
│   File Storage          │
│   (Images, etc.)        │
└─────────────────────────┘
```

### 13. Future Enhancements
1. API-first architecture with JSON responses
2. Frontend framework (Vue.js/React)
3. Advanced caching (Redis)
4. Search engine optimization
5. Analytics integration
6. Email notifications
7. User registration and profiles
8. Comment system for exhibitions/news
9. Social media integration
10. Mobile application
