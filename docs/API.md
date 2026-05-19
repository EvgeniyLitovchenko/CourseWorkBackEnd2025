# API Documentation (Museum Management System)

Base URL:
```
http://localhost
```

---

## 1. Get Exhibitions List

### GET /exhibitions/show

Description:
Returns a paginated list of exhibitions. Results can be filtered by type, date range, and search keywords. Returns 6 items per page by default.

Query Parameters:
```
page=0           (Page number, 0-indexed)
type_id=2        (Optional: Filter by exhibition type ID)
search=egypt     (Optional: Search keyword for exhibition title)
from_date=2025-01-01   (Optional: Start date filter, ISO 8601 format)
to_date=2025-03-31     (Optional: End date filter, ISO 8601 format)
```

Response 200:
```bash
{
  "success": true,
  "data": [
    {
      "id": 1,
      "title": "Ancient Egypt Collection",
      "description": "Discover the wonders of ancient Egyptian civilization with artifacts from the New Kingdom period.",
      "type_id": 2,
      "start_date": "2025-02-01",
      "end_date": "2025-03-31",
      "created_at": "2025-02-01T10:30:00Z"
    },
    {
      "id": 2,
      "title": "Medieval Weapons and Armor",
      "description": "An exploration of medieval military technology and armor craftsmanship.",
      "type_id": 3,
      "start_date": "2025-01-15",
      "end_date": null,
      "created_at": "2025-01-15T14:20:00Z"
    }
  ],
  "pagination": {
    "current_page": 0,
    "page_size": 6,
    "total_items": 15,
    "total_pages": 3
  }
}
```

❌ Error Response:
```bash
{
  "success": false,
  "error": "Invalid date format. Use YYYY-MM-DD",
  "code": "INVALID_DATE_FORMAT"
}
```

---

## 2. Get Exhibition Details

### GET /exhibitions/view/{id}

Description:
Returns detailed information about a specific exhibition including all associated images and metadata.

Path Parameters:
```
id               (Exhibition ID)
```

Response 200:
```bash
{
  "success": true,
  "data": {
    "id": 1,
    "title": "Ancient Egypt Collection",
    "description": "Discover the wonders of ancient Egyptian civilization with artifacts from the New Kingdom period.",
    "type_id": 2,
    "type_name": "Historical",
    "start_date": "2025-02-01",
    "end_date": "2025-03-31",
    "images": [
      {
        "id": 1,
        "image_path": "/public/images/exhibitions/egypt-1.jpg"
      },
      {
        "id": 2,
        "image_path": "/public/images/exhibitions/egypt-2.jpg"
      },
      {
        "id": 3,
        "image_path": "/public/images/exhibitions/egypt-3.jpg"
      }
    ],
    "created_at": "2025-02-01T10:30:00Z"
  }
}
```

❌ Error Response:
```bash
{
  "success": false,
  "error": "Exhibition not found",
  "code": "NOT_FOUND"
}
```

---

## 3. Get News List

### GET /news/show

Description:
Returns a paginated list of news articles. Articles are sorted by publication date in descending order (newest first). Returns 6 items per page by default.

Query Parameters:
```
page=0           (Page number, 0-indexed)
```

Response 200:
```bash
{
  "success": true,
  "data": [
    {
      "id": 5,
      "title": "Grand Opening: Medieval Exhibition",
      "excerpt": "Mark your calendars! Our new Medieval Weapons and Armor exhibition opens on February 15th.",
      "image": "/public/images/news/medieval-opening.jpg",
      "published_at": "2025-02-10T09:00:00Z"
    },
    {
      "id": 4,
      "title": "Recent Acquisitions Unveiled",
      "excerpt": "This month, we are thrilled to showcase five newly acquired artifacts from the Renaissance period.",
      "image": "/public/images/news/acquisitions.jpg",
      "published_at": "2025-02-05T14:30:00Z"
    }
  ],
  "pagination": {
    "current_page": 0,
    "page_size": 6,
    "total_items": 12,
    "total_pages": 2
  }
}
```

❌ Error Response:
```bash
{
  "success": false,
  "error": "Invalid page number",
  "code": "INVALID_PAGE"
}
```

---

## 4. Get News Article Details

### GET /news/view/{id}

Description:
Returns the full content of a specific news article including publication details and associated metadata.

Path Parameters:
```
id               (News article ID)
```

Response 200:
```bash
{
  "success": true,
  "data": {
    "id": 5,
    "title": "Grand Opening: Medieval Exhibition",
    "excerpt": "Mark your calendars! Our new Medieval Weapons and Armor exhibition opens on February 15th.",
    "content": "<h2>Grand Opening: Medieval Exhibition</h2><p>We are excited to announce the opening of our new Medieval Weapons and Armor exhibition!</p>",
    "image": "/public/images/news/medieval-opening.jpg",
    "published_at": "2025-02-10T09:00:00Z",
    "created_at": "2025-02-10T08:30:00Z"
  }
}
```

❌ Error Response:
```bash
{
  "success": false,
  "error": "News article not found",
  "code": "NOT_FOUND"
}
```

---

## 5. Get Contact Information

### GET /site/contacts

Description:
Returns museum contact information including address, phone numbers, email addresses, and operating hours.

Response 200:
```bash
{
  "success": true,
  "data": {
    "phone": "+380 44 123 45 67",
    "email": "info@museum.ua",
    "address": "Kyiv, Ukraine, 03680",
    "hours": {
      "monday_friday": "10:00 - 18:00",
      "saturday_sunday": "11:00 - 19:00"
    }
  }
}
```

---

## Common Error Codes

```
NOT_FOUND           → Resource doesn't exist (404)
INVALID_DATE_FORMAT → Invalid date format (400)
INVALID_PAGE        → Invalid page number (400)
INVALID_PARAMETER   → Invalid query parameter (400)
UNAUTHORIZED        → Authentication required (401)
FORBIDDEN           → Access denied (403)
SERVER_ERROR        → Internal server error (500)
```
