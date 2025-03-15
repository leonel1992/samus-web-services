
-- CLIENTES
INSERT IGNORE INTO `permissions` (`action`, `module`) VALUES
('access', 'customers');

INSERT IGNORE INTO `permissions_roles` (`value`, `rol`, `permission`) VALUES
(1, 'master', 'access|customers'),
(1, 'admin', 'access|customers'),
(1, 'coord', 'access|customers'),
(1, 'agent', 'access|customers'),
(1, 'office', 'access|customers'),
(0, 'client', 'access|customers'),
(1, 'assist-1', 'access|customers'),
(1, 'assist-2', 'access|customers'),
(1, 'assist-3', 'access|customers'),
(1, 'assist-4', 'access|customers'),
(1, 'assist-5', 'access|customers');