# theme-looks-pos-sells

## Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/developersharifuddin/theme-looks-pos-sells.git
   ```

   Navigate into the project directory:

   ```
   cd theme-looks-pos-sells
   ```

2. Install dependencies:

   ```
   composer install
   ```

   Copy the .env.example file to .env and configure your environment variables, including the database connection.

3. Generate application key:

   ```
   php artisan key:generate
   ```

4. Migrate the database:

   ```
   php artisan migrate
   ```

5. Seed the database:

   ```
   php artisan db:seed
   ```

Then a admin and some roduct seeding into users and items tables.

Usage
To access the application, navigate to http://localhost:8000 in your browser.

```
http://localhost:8000/login
```

# Admin Login:

email: admin@gmail.com
password: 12345678

![alt text](image.png)

# After login in, Redirect to admin dashboard.

![alt text](image-1.png)

# Go to product List

http://127.0.0.1:8000/admin/products

![alt text](image-2.png)

# Create a new product

http://127.0.0.1:8000/admin/products/create

![alt text](image-3.png)

# Edit product

http://127.0.0.1:8000/admin/products/20/edit

![alt text](image-4.png)

# View product

http://127.0.0.1:8000/admin/products/20

![alt text](image-5.png)

## Sells

# Go to Sells List: http://127.0.0.1:8000/admin/sales

![alt text](image-6.png)

# Click On "New Sales"

Add to cart or search product by name or SKU code and add to cart. then save Sells/order and saved data into database and redirect to Sells List page.

![alt text](image-7.png)

![alt text](image-8.png)

# Then click on option button and view sell details.

http://127.0.0.1:8000/admin/sales

![alt text](image-9.png)
http://127.0.0.1:8000/admin/sales/6

![alt text](image-10.png)

Thank you for your time considerations.
License
This project is licensed under the MIT License.
