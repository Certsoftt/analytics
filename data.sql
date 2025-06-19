-- Table: analytics_visits
CREATE TABLE analytics_visits (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    session_id VARCHAR(255) NULL,
    ip VARCHAR(45) NULL,
    country VARCHAR(255) NULL,
    region VARCHAR(255) NULL,
    city VARCHAR(255) NULL,
    url VARCHAR(255) NOT NULL,
    referrer VARCHAR(255) NULL,
    is_organic BOOLEAN DEFAULT FALSE,
    user_agent VARCHAR(255) NULL,
    visited_at TIMESTAMP NOT NULL,
    duration INT NULL,
    bounce BOOLEAN DEFAULT FALSE
);

-- Table: analytics_blog_clicks
CREATE TABLE analytics_blog_clicks (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    blog_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NULL,
    session_id VARCHAR(255) NULL,
    ip VARCHAR(45) NULL,
    clicked_at TIMESTAMP NOT NULL
);

-- Table: analytics_geo_data
CREATE TABLE analytics_geo_data (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    visit_id BIGINT UNSIGNED NOT NULL,
    country VARCHAR(255) NOT NULL,
    region VARCHAR(255) NULL,
    city VARCHAR(255) NULL
);

-- Table: analytics_goals
CREATE TABLE analytics_goals (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description VARCHAR(255) NULL,
    event VARCHAR(255) NOT NULL,
    target INT NULL,
    achieved BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table: analytics_error_logs
CREATE TABLE analytics_error_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    type VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    ip VARCHAR(45) NULL,
    user_id BIGINT UNSIGNED NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
