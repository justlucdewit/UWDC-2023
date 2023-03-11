-- SQL table for chat messages
CREATE TABLE IF NOT EXISTS `chat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `room` varchar(255) NOT NULL,
  `by` varchar(255) NOT NULL,
  `msg` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
);

-- SQL table for rooms
CREATE TABLE IF NOT EXISTS `room` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `maxCapacity` int(11) NOT NULL,
  `workers` varchar(65535) NOT NULL,
  PRIMARY KEY (`id`)
);

-- Seed the database with some rooms
INSERT INTO `room` (`name`, `maxCapacity`, `workers`) VALUES
('The office', 4, '[{"name":"John Doe","avatar":"avatar-18.svg"},{"name":"Jane Doe","avatar":"avatar-19.svg"}]'),
('Desk', 3, '[{"name":"Jerome Doe","avatar":"avatar-17.svg"}]'),
('Open office', 9, '[]'),
('Kitchen', 5, '[{"name":"Jill Doe","avatar":"avatar-16.svg"},{"name":"Jack Doe","avatar":"avatar-15.svg"}]'),
('Silent room', 1, '[{"name":"Jenny Doe","avatar":"avatar-14.svg"}]'),
('Silent room 2', 1, '[]'),
('Open office 2', 4, '[]'),
('Meeting room', 15, '[]'),
('Breakroom', 5, '[]'),
('Silent room 3', 2, '[]');

-- Seed the database with some chat messages
INSERT INTO `chat` (`id`, `room`, `by`, `msg`) VALUES
(1, 'test', 'test', 'test'),
(5, 'The office', 'sdfsdf', 'sdfdf'),
(6, 'The office', 'sdfsdf', 'this is a test'),
(7, 'The office', 'sdfsdf', 'sdfsdf'),
(8, 'Breakroom', 'luc de wit', 'i have some left over bread'),
(9, 'The office', 'sdfsdf', 'sdfsdf'),
(10, 'The office', 'test', 'hey there'),
(11, 'The office', 'sdfsdf', 'heyy, its me!'),
(12, 'The office', 'test', 'het sdfsdf how are you doing?'),
(13, 'The office', 'sdfsdf', 'im doing fine, how about you?'),
(14, 'The office', 'test', 'im more then fine!'),
(15, 'The office', 'sdf', 'this is a test'),
(16, 'Breakroom', 'luc de wit', 'i have some left over bread'),
(17, 'Desk', 'sdf', 'Hello there people at the desk!'),
(18, 'The office', 'sdf', 'seems like nobody is at the Desk :('),
(19, 'Desk', 'luc de wit', 'Heyy'),
(20, 'The office', 'luke', 'heyyyy');

