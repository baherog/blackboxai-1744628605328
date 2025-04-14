
Built by https://www.blackbox.ai

---

```markdown
# Asternic Call Center Stats for Issabel

## Project Overview

Asternic Call Center Stats for Issabel is a web-based application that provides comprehensive analytics and statistics for call centers using the Issabel system. The application allows users to track various metrics such as total calls, average call duration, and agent performance, all presented through an intuitive dashboard interface.

## Installation

To set up the project locally, follow these steps:

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/asternic-call-center-stats.git
   ```

2. **Navigate to the project directory**
   ```bash
   cd asternic-call-center-stats
   ```

3. **Configure your environment**
   - Edit the `config.php` file to set your database credentials:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'your_database_user');
   define('DB_PASS', 'your_database_password');
   define('DB_NAME', 'your_database_name');
   ```

4. **Set up the database**
   - Create the necessary tables in your MySQL database according to the application's requirements.

5. **Access the application**
   - Open your web browser and go to `http://localhost/path-to-your-project`

## Usage

1. Open the application in your web browser.
2. Log in with your credentials.
3. Navigate through the dashboard to view call statistics, agent performance, queue analysis, and more.
4. Customize reports based on specific date ranges and metrics.

## Features

- **User Authentication**: Secure login for accessing analytics.
- **Real-Time Statistics**: View real-time data on call metrics and agent performance.
- **Detailed Reporting**: Generate reports for daily, weekly, monthly, and yearly statistics.
- **Customizable Views**: Select specific agents and queues to analyze performance.
- **Visual Analytics**: Charts and graphs for better data understanding.

## Dependencies

The project utilizes the following dependencies (if specified in `package.json`):

```json
{
  "dependencies": {
    "axios": "^0.21.1",
    "chart.js": "^3.5.1"
  }
}
```

(Further dependencies can be added based on additional libraries used in the application.)

## Project Structure

Here's the structure of the project:

```
.
├── includes/
│   ├── functions.php      # Common reusable functions
│   ├── header.php         # Header template for pages
│   └── footer.php         # Footer template for pages
├── config.php             # Configuration file for database and settings
├── dashboard.php          # Main dashboard displaying statistics
├── login.php              # User login page
├── logout.php             # Logout functionality
├── index.php              # Home page redirection logic
├── various report pages   # (e.g., queue_hourly.php, agent_performance.php, etc.)
│   ├── agent_login_times.php
│   ├── queue_daily.php
│   ├── call_abandoned.php
│   ├── call_sla.php
│   └── custom_report.php
└── settings.php           # Page for configuring system settings
```

## Conclusion

Asternic Call Center Stats for Issabel is an efficient tool designed to enhance the monitoring and reporting capabilities of call centers. With its easy-to-navigate interface and robust feature set, it provides essential insights for better decision-making.
```