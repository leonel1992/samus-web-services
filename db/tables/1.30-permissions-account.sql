
-- ACCOUNT USER 
INSERT IGNORE INTO `permissions` (`action`, `module`) VALUES
('access', 'account');

INSERT IGNORE INTO `permissions_roles` (`value`, `rol`, `permission`) VALUES
(1, 'master', 'access|account'),
(1, 'admin', 'access|account'),
(1, 'coord', 'access|account'),
(1, 'agent', 'access|account'),
(1, 'office', 'access|account'),
(1, 'client', 'access|account'),
(1, 'assist-1', 'access|account'),
(1, 'assist-2', 'access|account'),
(1, 'assist-3', 'access|account'),
(1, 'assist-4', 'access|account'),
(1, 'assist-5', 'access|account');