
-- USUARIOS 
INSERT IGNORE INTO `permissions` (`action`, `module`) VALUES
('access', 'users');

INSERT IGNORE INTO `permissions_roles` (`value`, `rol`, `permission`) VALUES
(1, 'master', 'access|users'),
(1, 'admin', 'access|users'),
(1, 'coord', 'access|users'),
(0, 'agent', 'access|users'),
(0, 'office', 'access|users'),
(0, 'client', 'access|users'),
(0, 'assist-1', 'access|users'),
(0, 'assist-2', 'access|users'),
(0, 'assist-3', 'access|users'),
(0, 'assist-4', 'access|users'),
(0, 'assist-5', 'access|users');