
-- USUARIOS 
INSERT IGNORE INTO `permissions` (`action`, `module`) VALUES
('access', 'users');

-- INSERT IGNORE INTO `permissions_roles` (`id`, `value`, `rol`, `permission`) VALUES
-- ('admin---access--users', 1, 'admin', 'access--users'),
-- ('advanced---access--users', 1, 'advanced', 'access--users'),
-- ('client---access--users', 0, 'client', 'access--users');