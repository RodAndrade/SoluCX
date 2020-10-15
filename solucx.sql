SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `solucx` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `solucx`;

CREATE TABLE `drone` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `battery` int(3) NOT NULL,
  `max_speed` float(10,1) NOT NULL,
  `average_speed` float(10,1) NOT NULL,
  `status` enum('success','failed') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `drone` (`id`, `image`, `name`, `address`, `battery`, `max_speed`, `average_speed`, `status`) VALUES
(1, 'url', 'teste', 'asja sasa address', 22, 3.2, 2.3, 'failed'),
(3, '1', 'Teste 3', '1', 1, 1.0, 1.0, 'success'),
(4, '1', 'Teste 4', '1', 1, 1.0, 1.0, 'success'),
(5, '1', 'Teste 4', '1', 1, 1.0, 1.0, 'success'),
(6, '1', 'Teste 4', '1', 1, 1.0, 1.0, 'success'),
(7, '1', 'Teste 4', '1', 1, 1.0, 1.0, 'success'),
(8, '1', 'Teste 4', '1', 1, 1.0, 1.0, 'success'),
(9, '1', 'Teste 4', '1', 1, 1.0, 1.0, 'success'),
(10, '1', 'Teste 4', '1', 1, 1.0, 1.0, 'success'),
(11, '1', 'Teste 4', '1', 1, 1.0, 1.0, 'success'),
(12, '1', 'Teste 4', '1', 1, 1.0, 1.0, 'success'),
(13, '1', 'Teste 4', '1', 1, 1.0, 1.0, 'success'),
(14, '1', 'Teste 4', '1', 1, 1.0, 1.0, 'success'),
(15, '1', 'Teste 4', '1', 1, 1.0, 1.0, 'success'),
(16, '1', 'Teste 4', '1', 1, 1.0, 1.0, 'success'),
(17, '1', 'Teste 4', '1', 1, 1.0, 1.0, 'success'),
(18, '1', 'Teste 5', '1', 1, 1.0, 1.0, 'success'),
(19, '1', 'Teste novo', '1', 1, 1.0, 1.0, 'success'),
(20, '1', 'Teste novo', '1', 1, 1.0, 1.0, 'success'),
(21, '1', 'Teste novo b', '1', 1, 1.0, 1.0, 'success');


ALTER TABLE `drone`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `drone`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
