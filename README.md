# Laravel Swagger CRUD API

A comprehensive CRUD API with file upload/download capabilities built with Laravel 10, PostgreSQL, and Swagger/OpenAPI documentation. This project follows SOLID principles, clean architecture, and is optimized for performance with zero-lint errors.

> **Latest Update**: Enhanced DocumentController with comprehensive Swagger annotations, improved file handling, and robust error management.

## Features

- ✅ **Complete CRUD Operations** - Create, Read, Update, Delete documents
- ✅ **File Upload/Download** - Secure file handling with validation and binary response
- ✅ **PostgreSQL Database** - Optimized for performance and scalability
- ✅ **Swagger/OpenAPI Documentation** - Interactive API documentation with comprehensive annotations
- ✅ **Clean Architecture** - SOLID principles implementation
- ✅ **Performance Optimized** - Efficient queries and caching
- ✅ **Zero-Lint Errors** - Clean, maintainable code
- ✅ **Comprehensive Comments** - Well-documented codebase
- ✅ **pnpm Support** - Modern package management
- ✅ **Enhanced Error Handling** - Robust exception management and user-friendly responses
- ✅ **Advanced File Operations** - UUID-based file naming and secure storage
- ✅ **Type Safety** - Full type hints and return type declarations

## Tech Stack

- **Backend**: Laravel 10.x
- **Database**: PostgreSQL
- **Documentation**: Swagger/OpenAPI 3.0
- **Package Manager**: pnpm
- **PHP Version**: 8.1+

## Quick Start

### Prerequisites

- PHP 8.1 or higher
- Composer
- PostgreSQL
- pnpm
- Git

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/your-username/laravel-swagger.git
   cd laravel-swagger
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   pnpm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure PostgreSQL database**
   Update your `.env` file:
   ```env
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=laravel_swagger
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Run database migrations**
   ```bash
   php artisan migrate
   ```

7. **Generate Swagger documentation**
   ```bash
   php artisan l5-swagger:generate
   ```

8. **Start the development server**
   ```bash
   php artisan serve
   ```

9. **Build frontend assets (optional)**
   ```bash
   pnpm run dev
   ```

## API Documentation

Once the server is running, you can access:

- **API Documentation**: http://localhost:8000/api/documentation
- **API Info**: http://localhost:8000/api/info
- **Health Check**: http://localhost:8000/api/health

### Swagger Features

- **Interactive Testing**: Test all endpoints directly from the documentation
- **Request/Response Examples**: Comprehensive examples for all operations
- **Schema Validation**: Detailed request and response schemas
- **File Upload Support**: Binary file upload documentation
- **Error Response Documentation**: Complete error handling scenarios

## API Endpoints

### Documents CRUD

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/documents` | List all documents with pagination |
| POST | `/api/documents` | Create new document with file upload |
| GET | `/api/documents/{id}` | Get specific document |
| PUT | `/api/documents/{id}` | Update document metadata |
| DELETE | `/api/documents/{id}` | Delete document |
| GET | `/api/documents/{id}/download` | Download document file |

### Query Parameters

- **Pagination**: `page`, `per_page`
- **Filtering**: `category`, `status`
- **File Operations**: `remove_file` (for delete)

## Database Schema

### Documents Table

```sql
CREATE TABLE documents (
    id BIGSERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    file_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) UNIQUE NOT NULL,
    file_size BIGINT NOT NULL,
    mime_type VARCHAR(100) NOT NULL,
    category VARCHAR(50) DEFAULT 'general',
    status VARCHAR(20) DEFAULT 'active',
    uploaded_by VARCHAR(255),
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    deleted_at TIMESTAMP
);
```

## File Upload

### Supported Features

- **File Size Limit**: 10MB maximum
- **Secure Storage**: Files stored in `storage/app/documents/YYYY/MM/DD/`
- **UUID Naming**: Prevents filename conflicts
- **MIME Type Validation**: Automatic detection and validation
- **Metadata Tracking**: File size, original name, upload date

### Upload Example

```bash
curl -X POST http://localhost:8000/api/documents \
  -F "title=Sample Document" \
  -F "description=This is a test document" \
  -F "category=reports" \
  -F "uploaded_by=john_doe" \
  -F "file=@/path/to/your/file.pdf"
```

### Download Example

```bash
# Download file with proper headers
curl -X GET http://localhost:8000/api/documents/1/download \
  -H "Accept: application/json" \
  --output downloaded_file.pdf
```

### Response Examples

**Successful Upload Response:**
```json
{
  "success": true,
  "message": "Document uploaded successfully",
  "data": {
    "id": 1,
    "title": "Sample Document",
    "file_name": "sample.pdf",
    "file_size": 1024000,
    "mime_type": "application/pdf",
    "download_url": "/api/documents/1/download"
  }
}
```

## Development

### Code Standards

- **SOLID Principles**: Single Responsibility, Open/Closed, Liskov Substitution, Interface Segregation, Dependency Inversion
- **Clean Architecture**: Separation of concerns, dependency injection
- **PSR Standards**: PSR-4 autoloading, PSR-12 coding style
- **Zero-Lint Policy**: All code must pass linting checks

### Running Tests

```bash
# Run PHP tests
php artisan test

# Run linting
pnpm run lint

# Fix linting issues
pnpm run lint:fix
```

### Performance Optimizations

- **Database Indexing**: Optimized indexes for common queries
- **Query Optimization**: Selective field loading, eager loading
- **Caching**: Route caching, configuration caching
- **File Storage**: Efficient file organization and access

## Security Features

- **Input Validation**: Comprehensive request validation with Laravel Form Requests
- **File Security**: Secure file storage outside web root with UUID naming
- **Rate Limiting**: API endpoint protection against abuse
- **Error Handling**: Secure error responses without sensitive information exposure
- **CORS Configuration**: Proper cross-origin handling
- **File Type Validation**: MIME type verification and file extension checking
- **Path Traversal Protection**: Secure file path handling
- **SQL Injection Prevention**: Eloquent ORM protection

## Deployment

### Production Setup

1. **Environment Configuration**
   ```bash
   APP_ENV=production
   APP_DEBUG=false
   ```

2. **Optimize for Production**
   ```bash
   composer install --optimize-autoloader --no-dev
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

3. **Build Assets**
   ```bash
   pnpm run build
   ```

## Contributing

1. Fork the repository
2. Create a feature branch
3. Follow coding standards
4. Add tests for new features
5. Ensure zero-lint errors
6. Submit a pull request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Support

For support and questions:

- Create an issue on GitHub
- Check the API documentation at `/api/documentation`
- Review the code comments for implementation details

## Changelog

### v1.1.0 (Latest)
- Enhanced DocumentController with comprehensive Swagger annotations
- Improved file download with proper binary response handling
- Added detailed error handling and user-friendly messages
- Enhanced type safety with full type hints
- Improved file validation and security measures
- Added comprehensive API response examples
- Enhanced Swagger documentation with detailed schemas

### v1.0.0
- Initial release with complete CRUD functionality
- File upload/download capabilities
- PostgreSQL integration
- Swagger documentation
- Clean architecture implementation
