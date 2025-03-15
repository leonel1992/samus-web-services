
-- SEGURIDAD 
INSERT IGNORE INTO `permissions` (`action`, `module`) VALUES
('access', 'security');

INSERT IGNORE INTO `permissions_roles` (`value`, `rol`, `permission`) VALUES
(1, 'master', 'access|security'),
(1, 'admin', 'access|security'),
(0, 'coord', 'access|security'),
(0, 'agent', 'access|security'),
(0, 'office', 'access|security'),
(0, 'client', 'access|security'),
(0, 'assist-1', 'access|security'),
(0, 'assist-2', 'access|security'),
(0, 'assist-3', 'access|security'),
(0, 'assist-4', 'access|security'),
(0, 'assist-5', 'access|security');