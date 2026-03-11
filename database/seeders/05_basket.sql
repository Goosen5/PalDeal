-- Seed baskets for users
INSERT INTO basket (user_id, created_at) VALUES
  (1, '2026-03-01'),
  (2, '2026-03-02'),
  (3, '2026-03-03');

-- Seed basket_game relations (games in baskets)
INSERT INTO basket_game (basket_id, game_id) VALUES
  (1, 1),
  (1, 2),
  (2, 3),
  (2, 4),
  (3, 5),
  (3, 6);
