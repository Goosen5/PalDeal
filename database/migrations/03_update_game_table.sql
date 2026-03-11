-- Migration: Add columns to game table for full game card data
ALTER TABLE game ADD COLUMN platform TEXT DEFAULT 'Steam';
ALTER TABLE game ADD COLUMN old_price REAL DEFAULT 0.00;
ALTER TABLE game ADD COLUMN discount INTEGER DEFAULT 0;
ALTER TABLE game ADD COLUMN genre TEXT DEFAULT '';
ALTER TABLE game ADD COLUMN developer TEXT DEFAULT '';
