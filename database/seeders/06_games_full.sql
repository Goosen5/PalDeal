-- Seeder for game table with all required fields
DELETE FROM game;
INSERT INTO game (title, description, price, difficulty, image_url, platform, old_price, discount, genre, developer) VALUES
    ('Cyberpunk 2077', 'Futuristic RPG adventure.', 59.99, 'hard', 'assets/images/cyberpunk.webp', 'Steam', 69.99, 14, 'RPG', 'CD Projekt RED'),
    ('Minecraft', 'Sandbox building game.', 26.95, 'easy', 'assets/images/minecraft.webp', 'Steam', 29.99, 10, 'Sandbox', 'Mojang'),
    ('Valorant', 'Tactical FPS shooter.', 0.00, 'medium', 'assets/images/valorant.webp', 'Steam', 0.00, 0, 'FPS', 'Riot Games'),
    ('Stardew Valley', 'Farming and life simulator.', 14.99, 'easy', 'assets/images/stardew.webp', 'Steam', 19.99, 25, 'Simulation', 'ConcernedApe'),
    ('Dark Souls III', 'Challenging action RPG.', 49.99, 'nightmare', 'assets/images/darksouls3.webp', 'Steam', 59.99, 17, 'Action RPG', 'FromSoftware'),
    ('The Witcher 3', 'Epic fantasy RPG.', 39.99, 'hard', 'assets/images/witcher3.webp', 'Steam', 49.99, 20, 'RPG', 'CD Projekt RED');
