# Budget & Time Management Application

## Overview

This Laravel-based application is designed to streamline budget management and timesheet tracking for project-based businesses. It integrates with Clockify to provide comprehensive time tracking capabilities and automated client communication for budget monitoring and weekly timesheet distribution.

## Key Features

### 🏷️ Budget Management
The application supports two distinct budget categories:

#### Fixed Budget Projects
- **Client Payment**: Fixed amount paid upfront for the entire project
- **Hour Allocation**: Predetermined hours allocated to complete the project
- **Cost Tracking**: Monitor actual time spent against allocated hours
- **Project Monitoring**: Track progress and budget utilization

#### Prepaid Hours Projects
- **Prepaid Buckets**: Clients purchase hours in advance
- **Hour Rate Configuration**: Configurable hourly rates for accurate billing
- **Depletion Monitoring**: Automatic alerts when prepaid hours are running low
- **Real-time Tracking**: Live updates on remaining prepaid hours

### ⏰ Time Tracking Integration
- **Clockify Integration**: Seamless connection with Clockify for accurate time tracking
- **Project Selection**: Easy project selection for time logging
- **Automated Data Sync**: Real-time synchronization of tracked hours
- **Multi-project Support**: Handle multiple projects simultaneously

### 📊 Timesheet Management
- **Weekly Timesheets**: Automated generation of weekly timesheet reports
- **Project-based Reporting**: Filter timesheets by specific projects
- **Client Communication**: Direct timesheet delivery to clients
- **Customizable Formats**: Flexible timesheet formatting options

### 🔔 Notification System
- **Project Notifications**: Send updates by selecting specific Clockify projects
- **Budget Alerts**: Automatic notifications when budgets approach limits
- **Prepaid Hour Warnings**: Alerts when prepaid hour buckets are nearing depletion
- **Weekly Reminders**: Automated weekly timesheet distribution
- **Client Updates**: Regular project progress updates to clients

### 💰 Financial Tracking
- **Hourly Rate Management**: Configure and manage different hourly rates
- **Payment Tracking**: Monitor client payments and outstanding amounts
- **Budget vs. Actual**: Compare allocated budgets with actual costs
- **Revenue Reporting**: Generate financial reports and insights

## Target Use Cases

### Scenario 1: Fixed Budget Projects
Perfect for agencies working on fixed-price contracts where:
- Client pays a predetermined amount for project completion
- Hours need to be carefully managed within budget constraints
- Progress tracking is essential for profitability

### Scenario 2: Prepaid Hours Consulting
Ideal for consultants and service providers where:
- Clients purchase blocks of hours in advance
- Different hourly rates apply to different services
- Proactive communication about hour depletion is crucial
- Regular reporting maintains client transparency

## Technical Stack
- **Framework**: Laravel (PHP)
- **Frontend**: Livewire for dynamic interactions
- **Time Tracking**: Clockify API integration
- **Authentication**: Laravel authentication system
- **Database**: MySQL/PostgreSQL compatible
- **Notifications**: Email and in-app notification system

## Getting Started

### Prerequisites
- PHP 8.1 or higher
- Composer
- Node.js and NPM
- MySQL or PostgreSQL database
- Clockify API credentials

### Installation
1. Clone the repository
2. Run `composer install`
3. Copy `.env.example` to `.env` and configure database settings
4. Set up Clockify API credentials in `.env`
5. Run `php artisan migrate`
6. Run `npm install && npm run build`
7. Start the development server with `php artisan serve`

### Configuration
- Configure Clockify API credentials
- Set up email notification settings
- Configure hourly rates and default project settings
- Set up automated timesheet delivery schedule

## Available Commands

The application provides the following Artisan commands for managing data and integrations:

### Clockify Integration Commands

#### `php artisan clockify:populate-client-clockify-projects`
**Description**: Command pulls all clockify projects for a client and populates the projects database table.

**Usage**: 
```bash
php artisan clockify:populate-client-clockify-projects
```

**What it does**:
- Fetches all clients from the local database
- For each client, retrieves their associated projects from Clockify
- Creates or updates project records in the local database with:
  - Project name
  - Project color
  - Clockify project ID
  - Client association
- Provides real-time feedback on created/updated projects

**Prerequisites**:
- Clockify API credentials must be configured in `.env`
- Clients must exist in the local database with proper Clockify workspace/client ID associations

#### `php artisan app:populate-clockify-users`
**Description**: Command to pull all Clockify users and populate the clockify users database table.

**Usage**: 
```bash
php artisan app:populate-clockify-users
```

**What it does**:
- Fetches all clients from the local database
- For each client, retrieves their associated users from Clockify
- Creates or updates user records in the clockify_users table with:
  - User name
  - User email
  - Clockify user ID
- Provides real-time feedback on created/updated users

**Prerequisites**:
- Clockify API credentials must be configured in `.env`
- Clients must exist in the local database with proper Clockify workspace/client ID associations
- The clockify_users table must be migrated

## Support
For technical support or feature requests, please contact the development team.

---

*This application helps businesses maintain profitability through accurate time tracking, proactive budget management, and transparent client communication.*