
-- ADMINISTRAR 
INSERT IGNORE INTO `permissions` (`action`, `module`) VALUES
('access', 'manage');

INSERT IGNORE INTO `permissions_roles` (`value`, `rol`, `permission`) VALUES
(1, 'master', 'access|manage'),
(1, 'admin', 'access|manage'),
(0, 'coord', 'access|manage'),
(0, 'agent', 'access|manage'),
(0, 'office', 'access|manage'),
(0, 'client', 'access|manage'),
(0, 'assist-1', 'access|manage'),
(0, 'assist-2', 'access|manage'),
(0, 'assist-3', 'access|manage'),
(0, 'assist-4', 'access|manage'),
(0, 'assist-5', 'access|manage');


-- ADMINISTRAR GALERIA 
INSERT IGNORE INTO `permissions` (`action`, `module`) VALUES
('access', 'manage-gallery'),
('insert', 'manage-gallery'),
('delete', 'manage-gallery'),
('update', 'manage-gallery');

INSERT IGNORE INTO `permissions_roles` (`value`, `rol`, `permission`) VALUES
(1, 'master', 'access|manage-gallery'),
(1, 'master', 'insert|manage-gallery'),
(1, 'master', 'delete|manage-gallery'),
(1, 'master', 'update|manage-gallery'),

(1, 'admin', 'access|manage-gallery'),
(1, 'admin', 'insert|manage-gallery'),
(1, 'admin', 'delete|manage-gallery'),
(1, 'admin', 'update|manage-gallery');

-- ADMINISTRAR BINANCE 
-- INSERT IGNORE INTO `permissions` (`id`, `action`, `module`) VALUES
-- ('access--manage-binance', 'access', 'manage-binance');

-- INSERT IGNORE INTO `permissions_roles` (`id`, `value`, `rol`, `permission`) VALUES
-- ('admin---access--manage-binance', 1, 'admin', 'access--manage-binance'),
-- ('advanced---access--manage-binance', 1, 'advanced', 'access--manage-binance'),
-- ('client---access--manage-binance', 0, 'client', 'access--manage-binance');


-- ADMINISTRAR TASAS 
-- INSERT IGNORE INTO `permissions` (`id`, `action`, `module`) VALUES
-- ('access--manage-rates', 'access', 'manage-rates');

-- INSERT IGNORE INTO `permissions_roles` (`id`, `value`, `rol`, `permission`) VALUES
-- ('admin---access--manage-rates', 1, 'admin', 'access--manage-rates'),
-- ('advanced---access--manage-rates', 1, 'advanced', 'access--manage-rates'),
-- ('client---access--manage-rates', 0, 'client', 'access--manage-rates');