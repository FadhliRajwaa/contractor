# Database Setup - Dual Connection (Local & Aiven Cloud)

This document explains how to set up dual database connections for local MySQL and Aiven Cloud MySQL databases that work simultaneously without switching.

## Database Architecture

### Dual Connection Setup
The application supports **two separate database connections**:
- **`mysql`** - Local development database (default)
- **`aiven`** - Aiven Cloud database (production)

Both connections can be used simultaneously in the same application.

## Configuration Files

### 1. Environment Files
- `.env` - Contains both local AND Aiven credentials (NOT in repository)
- `.env.example` - Template for development (safe for GitHub)
- `.env.production.example` - Template for production with Aiven (safe for GitHub)

### 2. Key Configuration Variables
```bash
# Local Database (Primary Connection)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=contractor
DB_USERNAME=root
DB_PASSWORD=

# Aiven Cloud Database (Secondary Connection)
AIVEN_DB_HOST=your-aiven-host.aivencloud.com
AIVEN_DB_PORT=your-aiven-port
AIVEN_DB_DATABASE=your-database-name
AIVEN_DB_USERNAME=your-aiven-username  
AIVEN_DB_PASSWORD=your-aiven-password
```

**⚠️ Security Note:** Never commit real passwords to GitHub! Use `.env.example` for templates.

## Available Commands

### 1. Test Database Connections
```bash
# Test local database (default)
php artisan db:test-connection

# Test local database explicitly  
php artisan db:test-connection mysql

# Test Aiven database
php artisan db:test-connection aiven
```

### 2. Migrate Databases
```bash
# Migrate to local database
php artisan db:migrate mysql

# Migrate to Aiven database
php artisan db:migrate aiven

# Fresh migration (drops all tables)
php artisan db:migrate aiven --fresh

# Migration with seeder
php artisan db:migrate aiven --fresh --seed
```

### 3. Database Information & Monitoring
```bash
# Show info for all connections
php artisan db:info

# Show info for specific connection
php artisan db:info mysql
php artisan db:info aiven

# Shows: connection status, tables, sizes, etc.
```

### 3. Using Specific Connections in Code
```php
// Use local database (default)
$users = DB::table('users')->get();

// Use Aiven database explicitly
$users = DB::connection('aiven')->table('users')->get();

// Model with specific connection
User::on('aiven')->where('active', true)->get();

// Using DatabaseService helper
use App\Services\DatabaseService;

// Check if connection exists
if (DatabaseService::connectionExists('aiven')) {
    $users = DB::connection('aiven')->table('users')->get();
}

// Get connection info
$info = DatabaseService::getConnectionInfo('aiven');
echo "Connected to: {$info['host']}:{$info['port']}";

// Execute query on specific connection
$result = DatabaseService::query('aiven', 'SELECT COUNT(*) as total FROM users');

// Temporary switch connection
DatabaseService::useConnection('aiven', function() {
    return User::where('active', true)->count();
});
```

## Setup Steps

### Local Development Setup
1. **Ensure local MySQL is running (XAMPP/WAMP)**
2. **Create local database:**
   ```sql
   CREATE DATABASE contractor;
   ```
3. **Test local connection:**
   ```bash
   php artisan db:test-connection mysql
   ```
4. **Run local migrations:**
   ```bash
   php artisan db:migrate mysql
   php artisan db:seed --database=mysql
   ```

### Aiven Cloud Setup
1. **Get credentials from Aiven Console:**
   - Go to your Aiven MySQL service
   - Copy connection details (host, port, username, password)
   - Add to `.env` file as `AIVEN_DB_*` variables

2. **Test Aiven connection:**
   ```bash
   php artisan db:test-connection aiven
   ```

3. **Migrate to Aiven:**
   ```bash
   php artisan db:migrate aiven --fresh --seed
   ```

### Simultaneous Usage
You can now use both databases in the same application:
```php
// Local development data
$localUsers = DB::connection('mysql')->table('users')->get();

// Production Aiven data  
$productionUsers = DB::connection('aiven')->table('users')->get();
```

## Production Deployment

### Method 1: Using .env.production.example Template
1. **Copy production template:**
   ```bash
   cp .env.production.example .env
   ```

2. **Fill in your Aiven credentials:**
   - Get credentials from Aiven Console
   - Replace `your-aiven-*` placeholders with real values
   - **Never commit this .env file to repository!**

3. **Clear caches:**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

### Method 2: Environment Variables (Recommended for CI/CD)
Set environment variables directly on your server:
```bash
export DB_CONNECTION=aiven
export AIVEN_DB_HOST=your-aiven-host.aivencloud.com
export AIVEN_DB_PORT=your-aiven-port
export AIVEN_DB_USERNAME=your-aiven-username
export AIVEN_DB_PASSWORD=your-aiven-password
# etc...
```

### Using Both Connections
Keep `DB_CONNECTION=mysql` as default and use `DB::connection('aiven')` when needed for production data.

### 🔒 Security Best Practices
- **Never commit .env files with real credentials**
- **Use .env.example templates for documentation**
- **Store production credentials in secure environment variables**
- **Regularly rotate database passwords**

## Troubleshooting

### Connection Issues
1. **Check firewall settings**
2. **Verify SSL configuration**
3. **Test network connectivity:**
   ```bash
   telnet your-aiven-host.aivencloud.com your-aiven-port
   ```

### Migration Issues
1. **Check MySQL version compatibility**
2. **Review migration files for Aiven compatibility**
3. **Test with small migrations first**

### SSL Issues
- Aiven requires SSL connection
- SSL verification is disabled for easier connection
- Check PDO MySQL SSL options in `config/database.php`

## Monitoring

### Check Current Configuration
```bash
php artisan db:test-connection
```

### Verify Migrations
```bash
php artisan migrate:status
```

### Check Database Size (Aiven Console)
- Log in to Aiven Console
- Monitor database usage and performance
- Check connection limits and quotas

## Security Notes

1. **Never commit .env files with real credentials**
2. **Use environment variables in production**
3. **Rotate database passwords regularly**
4. **Monitor database access logs in Aiven Console**
5. **Use IP whitelisting if available**

## Performance Tips

1. **Use connection pooling in production**
2. **Monitor query performance in Aiven Console**
3. **Set appropriate timeout values**
4. **Use database indexes effectively**
5. **Consider read replicas for high-traffic applications**
