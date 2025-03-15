
-- CALCULADORA 
INSERT IGNORE INTO `permissions` (`action`, `module`) VALUES
('access', 'calculator');

INSERT IGNORE INTO `permissions_roles` (`value`, `rol`, `permission`) VALUES
(1, 'master', 'access|calculator'),
(1, 'admin', 'access|calculator'),
(1, 'coord', 'access|calculator'),
(1, 'agent', 'access|calculator'),
(1, 'office', 'access|calculator'),
(1, 'client', 'access|calculator'),
(1, 'assist-1', 'access|calculator'),
(1, 'assist-2', 'access|calculator'),
(1, 'assist-3', 'access|calculator'),
(1, 'assist-4', 'access|calculator'),
(1, 'assist-5', 'access|calculator');