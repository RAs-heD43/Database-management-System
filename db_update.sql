-- Database Migration Script
// Ensure we can rollback if needed
delimiter //

-- Create backup table
CREATE TABLE player_backup AS SELECT * FROM player;

delimiter ;

-- Drop foreign key constraint temporarily
ALTER TABLE player DROP FOREIGN KEY IF EXISTS fk_team;

delimiter //

-- Drop old player table
DROP TABLE IF EXISTS player;

delimiter ;

-- Recreate player table with new structure
CREATE TABLE player (
    id VARCHAR(255) NOT NULL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    blood_group VARCHAR(5) NOT NULL DEFAULT 'NOT SPECIFIED',
    position VARCHAR(20) NOT NULL DEFAULT 'NOT SPECIFIED',
    play_for VARCHAR(50) NOT NULL DEFAULT 'NOT SPECIFIED'
);

delimiter //

-- Insert existing data with defaults
INSERT INTO player (id, name, blood_group, position, play_for)
SELECT id, name, 'NOT SPECIFIED', 'NOT SPECIFIED', 'NOT SPECIFIED' FROM player_backup;

delimiter ;

-- Re-add foreign key with cascade
ALTER TABLE player
ADD CONSTRAINT fk_team
FOREIGN KEY (play_for) REFERENCES team(team_name)
ON UPDATE CASCADE
ON DELETE RESTRICT;

delimiter //

-- Clean up
DROP TABLE IF EXISTS player_backup;
//