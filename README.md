# Laravel AI Trading System

## Overview
The Laravel AI Trading System is a web application built using the Laravel framework that leverages artificial intelligence to facilitate automated trading strategies. This project is designed to help traders make informed decisions through data analysis and predictive modeling.

## Features
- **User Authentication**: Secure login and registration system with role-based access control.
- **AI-Powered Trading Bots**: Multiple trading bots with different risk levels and strategies.
- **Bot Management**: Activate, monitor, and close trading bots with real-time profit tracking.
- **Financial Operations**: Deposit and withdrawal management with admin approval workflow.
- **P2P Transfers**: User-to-user balance transfers within the platform.
- **KYC Verification**: Document upload and verification system for user compliance.
- **Referral System**: 10-level deep referral program with configurable commission rates.
- **Admin Dashboard**: Comprehensive analytics and management tools for administrators.
- **User Dashboard**: Detailed insights into trading performance, profits, and referral earnings.

## Setup Instructions
1. **Clone the Repository**:
   ```bash
   git clone https://github.com/dannybreed-ai/laravel-ai-trading-system.git
   cd laravel-ai-trading-system
   ```

2. **Install Dependencies**:
   Make sure you have Composer installed. Then run:
   ```bash
   composer install
   ```

3. **Environment Configuration**:
   Copy the `.env.example` file to `.env`:
   ```bash
   cp .env.example .env
   ```
   Update the `.env` file with your database and API settings.

4. **Generate Application Key**:
   ```bash
   php artisan key:generate
   ```

5. **Run Migrations**:
   ```bash
   php artisan migrate
   ```

6. **Seed the Database** (Optional):
   ```bash
   php artisan db:seed
   ```
   This will create sample users, bots, and data. Default credentials:
   - Admin: admin@stockandfi.com / password
   - Demo User: demo@stockandfi.com / password

7. **Build Frontend Assets**:
   ```bash
   npm install
   npm run build
   ```

8. **Start the Local Development Server**:
   ```bash
   php artisan serve
   ```

9. **Access the Application**:
   Open your browser and go to `http://localhost:8000`.

## Events System

The system uses Laravel's event system for important actions:

| Event | Description | Listeners |
|-------|-------------|-----------|
| `BotActivated` | Fired when a user activates a trading bot | `LogBotActivated` |
| `BotClosed` | Fired when a bot activation is closed | `LogBotClosed` |
| `DepositApproved` | Fired when an admin approves a deposit | `LogDepositApproved` |
| `WithdrawalApproved` | Fired when an admin approves a withdrawal | `LogWithdrawalApproved` |

All events are logged for audit purposes and can be extended for notifications or other actions.

## Artisan Commands

### bot:simulate-profit

Simulates profit generation for active bot activations. Useful for testing and demonstration.

```bash
# Run normally
php artisan bot:simulate-profit

# Dry run (shows what would happen without making changes)
php artisan bot:simulate-profit --dry-run
```

This command:
- Finds all active bot activations
- Generates random trades based on bot parameters
- Updates current profit for each activation
- Logs all actions for audit

## Referral System

The platform features a 10-level deep referral system with configurable commission rates:

| Level | Default Commission | ENV Variable |
|-------|-------------------|--------------|
| 1 | 5.00% | `REFERRAL_LEVEL_1` |
| 2 | 3.00% | `REFERRAL_LEVEL_2` |
| 3 | 2.00% | `REFERRAL_LEVEL_3` |
| 4 | 1.50% | `REFERRAL_LEVEL_4` |
| 5 | 1.00% | `REFERRAL_LEVEL_5` |
| 6 | 0.75% | `REFERRAL_LEVEL_6` |
| 7 | 0.50% | `REFERRAL_LEVEL_7` |
| 8 | 0.25% | `REFERRAL_LEVEL_8` |
| 9 | 0.15% | `REFERRAL_LEVEL_9` |
| 10 | 0.10% | `REFERRAL_LEVEL_10` |

### Referral Configuration

Edit your `.env` file to customize referral settings:

```env
# Enable/disable referral system
REFERRAL_ENABLED=true

# Maximum referral depth
REFERRAL_MAX_DEPTH=10

# Custom commission rates (optional)
REFERRAL_LEVEL_1=5.00
REFERRAL_LEVEL_2=3.00
# ... and so on
```

## Configuration via ENV

### Trading Configuration

```env
# Trading Fees
TRADING_FEE_MAKER=0.10
TRADING_FEE_TAKER=0.15

# Bot Limits
TRADING_MAX_CONCURRENT_BOTS=5
TRADING_MIN_INVESTMENT=100.00
TRADING_MAX_INVESTMENT=10000.00

# Profit Distribution
TRADING_PROFIT_USER_PERCENTAGE=85.00
TRADING_PROFIT_PLATFORM_PERCENTAGE=15.00

# Risk Weights
TRADING_RISK_WEIGHT_LOW=0.50
TRADING_RISK_WEIGHT_MEDIUM=1.00
TRADING_RISK_WEIGHT_HIGH=1.50
TRADING_RISK_WEIGHT_VERY_HIGH=2.00
```

## API Endpoints

The system provides JSON API endpoints for frontend integration:

### Authenticated Endpoints (requires Bearer token)

```
GET /api/user - Get authenticated user
GET /api/bots - List all active bots
GET /api/bots/{id} - Get bot details
GET /api/activations - List user's bot activations
GET /api/activations/{id}/status - Get activation status (for polling)
GET /api/trades - List user's trades
GET /api/stats - Get user statistics
```

## Security Features

- **CSRF Protection**: All forms are protected with CSRF tokens
- **Role-Based Access Control**: Admin and user roles with middleware
- **Policy-Based Authorization**: Policies for deposits, withdrawals, and bot activations
- **KYC Verification**: Optional KYC middleware for restricted areas
- **Rate Limiting**: Admin routes are rate-limited (60 requests per minute)
- **Password Hashing**: Bcrypt password hashing
- **SQL Injection Prevention**: Eloquent ORM with parameter binding

## Architecture

### Models & Relationships

- **User**: Central user model with relationships to all other entities
- **Bot**: Trading bot configurations
- **BotActivation**: Active or closed bot instances
- **Trade**: Individual trades executed by bots
- **Transaction**: Financial transaction records
- **Deposit/Withdrawal**: Financial operations
- **P2pTransfer**: User-to-user transfers
- **KycRecord**: KYC verification documents
- **ReferralEarning**: Commission records

### Database Indexes

Strategic indexes on frequently queried columns:
- `user_id` on all user-related tables
- `status` on operational tables (deposits, withdrawals, etc.)
- `reference` on transactions
- Composite indexes on `[source_type, source_id]` for polymorphic relations

## Documentation
For more detailed documentation, please refer to the [Laravel Documentation](https://laravel.com/docs).