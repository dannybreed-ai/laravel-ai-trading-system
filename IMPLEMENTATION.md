# Laravel AI Trading System - Implementation Documentation

## Overview
This is a comprehensive Laravel-based AI Trading System with automated bot trading, user management, KYC verification, deposits/withdrawals, and a multi-level referral program.

## Project Structure

### Models
- **User** - User authentication and profile management with referral system
- **Bot** - AI trading bot definitions with profit ranges and risk levels
- **BotActivation** - Active/completed bot runs for users
- **Transaction** - Complete financial transaction history
- **Deposit** - User deposit requests with approval workflow
- **Withdrawal** - User withdrawal requests with approval workflow
- **Trade** - Individual trade records linked to bots
- **ReferralEarning** - Multi-level referral commission tracking
- **KycRecord** - KYC document submissions and verification
- **P2pTransfer** - Peer-to-peer fund transfers between users

### Controllers

#### Authentication
- `LoginController` - User login/logout
- `RegisterController` - New user registration with referral codes

#### Dashboards
- `UserDashboardController` - User overview with stats, active bots, transactions
- `AdminDashboardController` - Admin metrics and pending approvals

#### Trading
- `TradingController` - Bot listing, activation, deactivation, trade history

#### Finance
- `DepositController` - Deposit CRUD and admin approval/rejection
- `WithdrawalController` - Withdrawal CRUD and admin approval/rejection
- `P2pTransferController` - User-to-user transfers

#### KYC
- `KycController` - Document submission and admin review

#### Referral
- `ReferralController` - Referral tree and earnings history

### Middleware
- `EnsureKycVerified` - Restricts features to KYC-verified users
- `AdminOnly` - Admin-only access control

### Form Requests
- `ActivateBotRequest` - Bot activation validation
- `StoreDepositRequest` - Deposit submission validation
- `StoreWithdrawalRequest` - Withdrawal validation
- `StoreKycRequest` - KYC document upload validation
- `P2pTransferRequest` - P2P transfer validation

### Routes

#### Web Routes (`routes/web.php`)
- Authentication: `/login`, `/register`, `/logout`
- User Dashboard: `/dashboard`
- Trading: `/trading/bots`, `/trading/activations`, `/trading/trades`
- Finance: `/finance/deposits`, `/finance/withdrawals`
- P2P: `/p2p`, `/p2p/transfer`
- KYC: `/kyc/submit`
- Referral: `/referral/tree`, `/referral/earnings`
- Admin: `/admin/*` (protected by admin middleware)

#### API Routes (`routes/api.php`)
- `/api/user` - Current user info
- `/api/bots` - List active bots
- `/api/activations` - User's bot activations
- `/api/trades` - User's trade history
- `/api/transactions` - User's transactions
- `/api/stats` - User statistics

### Views (Blade Templates)
- **Layouts**: `layouts/app.blade.php` - Main layout with Tailwind CSS
- **Auth**: Login, Register
- **Dashboards**: User and Admin dashboards
- **Trading**: Bots listing, activations management
- **Finance**: Deposits and withdrawals management
- **KYC**: Submission form and admin review
- **Referral**: Tree view and earnings
- **P2P**: Transfer form and history

### Frontend Assets
- **CSS**: `resources/css/app.css` - Tailwind with custom utilities
- **JS**: 
  - `resources/js/app.js` - Main app initialization with Alpine.js
  - `resources/js/admin.js` - Admin charts with ApexCharts
  - `resources/js/trading.js` - Trading bot interactions with SweetAlert2

### Configuration
- `config/referral.php` - 10-level referral commission structure
- `config/trading.php` - Trading limits, fees, risk levels
- `config/app.php` - Application settings
- `config/database.php` - Database configuration
- `config/auth.php` - Authentication guards and providers
- `config/session.php` - Session management
- `config/filesystems.php` - File storage configuration

### Database Migrations
All tables with proper indexes and foreign keys:
- users (with referral system)
- bots
- bot_activations
- transactions
- deposits
- withdrawals
- trades
- referral_earnings
- kyc_records
- p2p_transfers

### Seeders
- `UserSeeder` - Creates admin and demo users
- `BotSeeder` - Creates 4 sample trading bots with different strategies

### Events & Listeners
- `BotActivated` - Fired when a bot is activated
- `BotClosed` - Fired when a bot is closed
- `DepositApproved` - Fired when deposit is approved
- `WithdrawalApproved` - Fired when withdrawal is approved
- `LogBotActivation` - Logs bot activation to system logs

## Setup Instructions

1. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

2. **Environment Configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Database Setup**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

4. **Build Frontend Assets**
   ```bash
   npm run build
   # Or for development
   npm run dev
   ```

5. **Create Storage Link**
   ```bash
   php artisan storage:link
   ```

6. **Start Development Server**
   ```bash
   php artisan serve
   ```

## Default Credentials

### Admin
- Email: `admin@admin.com`
- Password: `password`

### Demo User
- Email: `demo@stockandfi.com`
- Password: `password`

## Key Features

### Trading Bots
- AI-powered automated trading
- Multiple risk levels (low, medium, high)
- Configurable investment amounts
- Daily profit ranges
- Duration-based activations

### Financial Management
- Deposit system with crypto/bank transfer
- Withdrawal with automatic fee calculation
- P2P transfers between users
- Complete transaction history

### KYC Verification
- Document upload (passport, ID, license)
- Admin review workflow
- Status tracking

### Referral Program
- 10-level deep referral structure
- Configurable commission rates
- Real-time earnings tracking
- Referral tree visualization

### Admin Panel
- User management
- Deposit/withdrawal approvals
- KYC review
- System metrics dashboard

## Technology Stack
- Laravel 10.x
- Tailwind CSS 3.x
- Alpine.js 3.x
- ApexCharts 3.x
- SweetAlert2
- Vite 4.x

## Security Features
- CSRF protection
- XSS protection via Blade escaping
- SQL injection protection via Eloquent ORM
- Password hashing
- Admin-only middleware
- KYC verification gates
- Transaction validation

## Future Enhancements
- Real trading API integration
- Two-factor authentication
- Email notifications
- Real-time WebSocket updates
- Advanced analytics dashboard
- Mobile app support
