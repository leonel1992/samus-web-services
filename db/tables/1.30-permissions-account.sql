
-- ACCOUNT USER 
INSERT IGNORE INTO `permissions` (`action`, `module`) VALUES
('access', 'account');

-- INSERT IGNORE INTO `permissions_roles` (`id`, `value`, `rol`, `permission`) VALUES
-- ('admin---access--account', 1, 'admin', 'access--account'),
-- ('advanced---access--account', 1, 'advanced', 'access--account'),
-- ('client---access--account', 1, 'client', 'access--account');