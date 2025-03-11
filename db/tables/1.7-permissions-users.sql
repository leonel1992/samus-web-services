-- -----------
-- USUARIOS --
-- -----------
INSERT INTO `modules` (`id`, `module`, `submodule`, `link_es`) VALUES
('users', 'Usuarios', '', '');

INSERT INTO `permissions` (`id`, `action`, `module`) VALUES
('access--users', 'access', 'users');

INSERT INTO `permissions_roles` (`id`, `value`, `rol`, `permission`) VALUES
('admin---access--users', 1, 'admin', 'access--users'),
('advanced---access--users', 1, 'advanced', 'access--users'),
('client---access--users', 0, 'client', 'access--users');