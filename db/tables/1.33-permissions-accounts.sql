
-- CUENTAS 
INSERT IGNORE INTO `permissions` (`action`, `module`) VALUES
('access', 'accounts');

INSERT IGNORE INTO `permissions_roles` (`value`, `rol`, `permission`) VALUES
(1, 'master', 'access|accounts'),
(1, 'admin', 'access|accounts'),
(1, 'coord', 'access|accounts'),
(1, 'agent', 'access|accounts'),
(1, 'office', 'access|accounts'),
(0, 'client', 'access|accounts'),
(1, 'assist-1', 'access|accounts'),
(1, 'assist-2', 'access|accounts'),
(1, 'assist-3', 'access|accounts'),
(1, 'assist-4', 'access|accounts'),
(1, 'assist-5', 'access|accounts');