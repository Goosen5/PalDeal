-- Seeder for users table
-- Passwords are hashed using SHA-256 for RGPD compliance
INSERT INTO users (name, email, password, is_admin) VALUES
    ('Goose_n5', 'goose_n5@example.com', HEX(hash_password('SuperSecret123')), 1),
    ('Alice', 'alice@example.com', HEX(hash_password('alicepass')), 0),
    ('Bob', 'bob@example.com', HEX(hash_password('bobpass')), 0);

-- You must run the hash_password function before this insert, see 00_functions.sql
