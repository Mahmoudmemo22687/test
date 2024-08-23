CREATE TABLE Users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Creating the password_reset_tokens table
CREATE TABLE password_reset_tokens (
    email VARCHAR(255) PRIMARY KEY,
    token VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL

);

-- Dropping the password_reset_tokens table

CREATE TABLE failed_jobs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid VARCHAR(255) UNIQUE NOT NULL,
    connection TEXT NOT NULL,
    queue TEXT NOT NULL,
    payload LONGTEXT NOT NULL,
    exception LONGTEXT NOT NULL,
    failed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
);

-- Dropping the failed_jobs table

-- Creating the personal_access_tokens table
CREATE TABLE personal_access_tokens (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tokenable_type VARCHAR(255) NOT NULL,
    tokenable_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    token VARCHAR(64) UNIQUE NOT NULL,
    abilities TEXT NULL,
    last_used_at TIMESTAMP NULL DEFAULT NULL,
    expires_at TIMESTAMP NULL DEFAULT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

CREATE INDEX personal_access_tokens_tokenable_type_tokenable_id_index 
ON personal_access_tokens (tokenable_type, tokenable_id);


-- Creating the stores table
CREATE TABLE stores (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    whatsapp_number VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    store_name VARCHAR(255) NOT NULL,
    domain VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    business_type VARCHAR(255) NOT NULL,
    shippable_products BOOLEAN NOT NULL,
    non_shippable_products BOOLEAN NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

-- Dropping the stores table




-- Creating the templates table
CREATE TABLE templates (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

-- Dropping the templates table


-- Adding the template_id column and foreign key constraint
ALTER TABLE stores
ADD COLUMN template_id BIGINT UNSIGNED NULL,
ADD CONSTRAINT fk_template_id
FOREIGN KEY (template_id) REFERENCES templates(id);

-- Dropping the foreign key constraint and the template_id column
ALTER TABLE stores
DROP FOREIGN KEY fk_template_id,
DROP COLUMN template_id;





-- Creating the products table
CREATE TABLE products (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(8, 2) NOT NULL,
    description TEXT NOT NULL,
    quantity INT NOT NULL,
    store_id BIGINT UNSIGNED NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,

    -- Adding the foreign key constraint for store_id
    FOREIGN KEY (store_id) REFERENCES stores(id) ON DELETE SET NULL
);

-- Dropping the products table



-- Creating the orders table
CREATE TABLE orders (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    store_id BIGINT UNSIGNED NOT NULL,
    whatsapp_number VARCHAR(255) NOT NULL,
    invoice_number VARCHAR(255) NOT NULL,
    customer_name VARCHAR(255) NOT NULL,
    order_date DATE NOT NULL,
    is_completed BOOLEAN NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,

    -- Adding the foreign key constraint for store_id
    FOREIGN KEY (store_id) REFERENCES stores(id) ON DELETE CASCADE
);

-- Dropping the orders table




-- Creating the discounts table
CREATE TABLE discounts (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(255) NULL,
    percentage DECIMAL(5, 2) NOT NULL,
    start_date DATE NULL,
    end_date DATE NULL,
    is_global BOOLEAN DEFAULT FALSE,
    product_id BIGINT UNSIGNED NULL,
    is_unlimited BOOLEAN DEFAULT FALSE,
    max_uses INT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,

    -- Adding the foreign key constraint for product_id
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Dropping the discounts table



-- Creating the banned_buyers table
CREATE TABLE banned_buyers (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    whatsapp_number VARCHAR(255) UNIQUE NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

-- Dropping the banned_buyers table



-- Creating the delivery table
CREATE TABLE delivery (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    area VARCHAR(255) NOT NULL,
    cost DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

-- Dropping the delivery table



-- Creating the team table
CREATE TABLE team (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    whatsapp_number VARCHAR(255) NOT NULL,
    job_title VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL,
    national_id VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);
CREATE TABLE complaints (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Dropping the team table



-- Creating the support_requests table
CREATE TABLE support_requests (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    description TEXT NOT NULL,
    image_path VARCHAR(255) NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

-- Dropping the support_requests table



-- Creating the pricing_plans table
CREATE TABLE pricing_plans (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    type VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

-- Dropping the pricing_plans table



CREATE TABLE PaymentMethods (
    id INT AUTO_INCREMENT PRIMARY KEY,
    method_name VARCHAR(50),
    details JSON,  -- لتخزين أي تفاصيل إضافية خاصة بطريقة الدفع
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Adding payment_method_id column and foreign key constraint to the stores table
ALTER TABLE stores
ADD COLUMN payment_method_id BIGINT UNSIGNED NULL,
ADD CONSTRAINT fk_payment_method
FOREIGN KEY (payment_method_id) REFERENCES payment_methods(id);

-- Dropping the foreign key constraint and column from the stores table
ALTER TABLE stores
DROP FOREIGN KEY fk_payment_method,
DROP COLUMN payment_method_id;

-- Creating the product_images table
CREATE TABLE product_images (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    image_path VARCHAR(255) NOT NULL,
    product_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,

    -- Adding the foreign key constraint for product_id
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Dropping the product_images table



-- Creating the likes table
CREATE TABLE likes (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    sizes JSON NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

-- Dropping the likes table


-- Creating the shop_products table
CREATE TABLE shop_products (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(8, 2) NOT NULL,
    description TEXT NOT NULL,
    quantity INT NOT NULL,
    sizes JSON NULL,
    colors JSON NULL,
    store_id JSON NULL, -- This field is defined as JSON, but it might be more appropriate to use BIGINT UNSIGNED if it references another table
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

-- Dropping the shop_products table


-- Creating the conversations table
CREATE TABLE conversations (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_one_id BIGINT UNSIGNED NOT NULL,
    user_two_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,

    -- Adding foreign key constraints
    FOREIGN KEY (user_one_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (user_two_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Dropping the conversations table


-- Creating the messages table
CREATE TABLE messages (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    conversation_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,

    -- Adding foreign key constraints
    FOREIGN KEY (conversation_id) REFERENCES conversations(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Dropping the messages table

