-- ------------
-- SEGURIDAD --
-- ------------
INSERT INTO `modules` (`id`, `module`, `submodule`, `link_es`) VALUES
('security', 'Seguridad', '', '');

INSERT INTO `permissions` (`id`, `action`, `module`) VALUES
('access--security', 'access', 'security');

INSERT INTO `permissions_roles` (`id`, `value`, `rol`, `permission`) VALUES
('admin---access--security', 1, 'admin', 'access--security'),
('advanced---access--security', 1, 'advanced', 'access--security'),
('client---access--security', 0, 'client', 'access--security');