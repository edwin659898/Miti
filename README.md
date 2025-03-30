# Miti Magazine Laravel App

## Introduction
Miti Magazine is a Laravel-based web application that allows users to browse, read, and subscribe to digital books online. The platform provides a seamless subscription-based payment system using Mpesa, Stripe, and PayPal.

## Features
- Browse and view digital books online
- Subscription-based access to premium content
- Secure payment integration with Mpesa, Stripe, and PayPal
- User authentication and account management
- Admin panel for managing books and subscriptions

## Technologies Used
- **Backend:** Laravel (PHP Framework)
- **Frontend:** Blade templates, Tailwind CSS
- **Database:** MySQL
- **Payment Gateways:** Mpesa, Stripe, PayPal
- **Authentication:** Laravel Sanctum / Laravel Breeze

## Installation

### Prerequisites
Ensure you have the following installed on your system:
- PHP >= 8.0
- Composer
- MySQL
- Node.js & NPM

### Setup Steps
1. Clone the repository:
   ```sh
   git clone https://github.com/yourusername/miti-magazine.git
   cd miti-magazine
   ```
2. Install dependencies:
   ```sh
   composer install
   npm install && npm run dev
   ```
3. Set up environment variables:
   ```sh
   cp .env.example .env
   ```
   Configure database, payment credentials, and other required settings in the `.env` file.
4. Generate application key:
   ```sh
   php artisan key:generate
   ```
5. Run migrations and seed database:
   ```sh
   php artisan migrate --seed
   ```
6. Serve the application:
   ```sh
   php artisan serve
   ```

## Payment Integration
The platform supports three payment gateways:
- **Mpesa** (via Daraja API)
- **Stripe** (for credit/debit card transactions)
- **PayPal** (for global transactions)

### Configuring Payments
Set the respective API keys in the `.env` file:
```env
MPESA_CONSUMER_KEY=your_mpesa_consumer_key
MPESA_CONSUMER_SECRET=your_mpesa_consumer_secret
STRIPE_KEY=your_stripe_key
STRIPE_SECRET=your_stripe_secret
PAYPAL_CLIENT_ID=your_paypal_client_id
PAYPAL_SECRET=your_paypal_secret
```

## Usage
1. Register or log in as a user.
2. Browse available books.
3. Subscribe to a plan using the available payment options.
4. Access premium books upon successful payment.

## Contributing
Contributions are welcome! Follow these steps:
1. Fork the repository.
2. Create a new feature branch.
3. Commit changes and push to your fork.
4. Submit a pull request for review.

## License
This project is licensed under the MIT License.

## Contact
For support, reach out to [edwinkiuma.com](mailto:edwinkiuma.com).
(https://miti-magazine.betterglobeforestry.com/) Website to Miti App

