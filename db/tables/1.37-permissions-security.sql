
-- SEGURIDAD 
INSERT IGNORE INTO `permissions` (`action`, `module`) VALUES
('access', 'security');

-- INSERT IGNORE INTO `permissions_roles` (`id`, `value`, `rol`, `permission`) VALUES
-- ('admin---access--security', 1, 'admin', 'access--security'),
-- ('advanced---access--security', 1, 'advanced', 'access--security'),
-- ('client---access--security', 0, 'client', 'access--security');