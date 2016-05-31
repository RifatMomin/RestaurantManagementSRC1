-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 30, 2016 at 11:33 PM
-- Server version: 5.7.12-0ubuntu1
-- PHP Version: 7.0.4-7ubuntu2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ProjectDAW2_Restaurant`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `user_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`user_id`, `admin_id`) VALUES
(16, 1),
(17, 2),
(18, 3),
(19, 4),
(20, 5);

-- --------------------------------------------------------

--
-- Table structure for table `chef`
--

CREATE TABLE `chef` (
  `user_id` int(11) NOT NULL,
  `chef_id` int(11) NOT NULL,
  `chef_level` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `chef`
--

INSERT INTO `chef` (`user_id`, `chef_id`, `chef_level`) VALUES
(6, 1, 'Head Chef'),
(7, 2, 'Sub Head Chef'),
(8, 3, 'Kitchen Assistant'),
(9, 4, 'Kitchen Assistant'),
(10, 5, 'Kitchen Assistant');

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `client_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`client_id`, `user_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(25) NOT NULL,
  `priority` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_id`, `course_name`, `priority`) VALUES
(1, 'First', 2),
(2, 'Second', 3),
(3, 'Dessert', 4),
(4, 'Drink', 1),
(6, 'Appetizer', 1),
(7, 'Alcoholic Drink', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ingredient`
--

CREATE TABLE `ingredient` (
  `ingredient_id` int(11) NOT NULL,
  `ingredient_name` varchar(25) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ingredient`
--

INSERT INTO `ingredient` (`ingredient_id`, `ingredient_name`, `price`) VALUES
(2, 'Huevo', 3),
(3, 'Leche', 5),
(4, 'Carne vacuna', 3),
(5, 'Queso', 4),
(6, 'Pollo', 1),
(7, 'Carne porcina', 3),
(8, 'Arroz', 5),
(9, 'Fetuccini', 3),
(10, 'Nata liquida', 2),
(11, 'Nata p/montar', 3),
(15, 'Patata', 1),
(17, 'Naranja', 4),
(18, 'Pan Bimbo', 2),
(19, 'Atún', 4),
(20, 'Macarrones', 4),
(30, 'Tomate', 3),
(31, 'Pimienta', 34),
(33, 'Fruta', 0.5),
(34, 'Bebida', 1.5),
(35, 'Spaghettis', 0.5),
(37, 'Salmón', 15);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `menu_id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `image` varchar(120) NOT NULL,
  `price` float NOT NULL,
  `description` text,
  `personalized` int(11) NOT NULL DEFAULT '1',
  `active` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menu_id`, `name`, `image`, `price`, `description`, `personalized`, `active`) VALUES
(1, 'Entrecot', 'images/menus/menu_5742e9e1ca9da.jpg', 21, 'Entrecot con Patatas Fritas', 1, 1),
(59, 'Canelones', 'images/menus/canelones.jpg', 19, 'Canelones de Verduras', 0, 1),
(60, 'Salmón salvaje', 'images/menus/salmon.jpg', 25, 'Salmón a la plancha', 1, 1),
(61, 'Mediterráneo', 'images/menus/pastasalad.jpg', 15, 'Ensalada Ligera y deliciosa', 1, 0),
(62, 'Macarrones Boloñesa', 'images/menus/menu_5746cf69d9210.jpg', 6.5, 'Unos macarrones de lo mejorcito', 1, 1),
(63, 'Sopa de Cebolla', 'images/menus/onion-soup-recipe.jpg', 20, 'La clásica sopa francesa', 1, 1),
(64, 'Arroz frito', 'images/menus/arrozfrito.jpg', 10, 'Arroz frito estilo chino', 0, 0),
(65, 'Menu de Primavera', 'images/menus/menu_57483cffd2d46.jpg', 3, 'Menu ligero y fresco', 1, 1),
(67, 'Menu_Antonio_2016-05-30', 'images/menus/image.jpg', 6.5, '', 0, 0),
(68, 'Menu0_Antonio_2016-05-30', 'images/menus/image.jpg', 6.5, '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `menu_has_item`
--

CREATE TABLE `menu_has_item` (
  `menu_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menu_has_item`
--

INSERT INTO `menu_has_item` (`menu_id`, `item_id`) VALUES
(1, 2),
(59, 2),
(60, 2),
(61, 2),
(62, 2),
(64, 2),
(68, 2),
(1, 3),
(59, 3),
(60, 3),
(61, 3),
(63, 3),
(64, 3),
(67, 3),
(68, 3),
(59, 4),
(60, 4),
(61, 4),
(62, 4),
(64, 4),
(67, 4),
(68, 4),
(62, 60),
(63, 60),
(64, 60),
(65, 60),
(67, 60),
(68, 60),
(65, 61),
(63, 62);

-- --------------------------------------------------------

--
-- Table structure for table `menu_item`
--

CREATE TABLE `menu_item` (
  `item_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `image` varchar(120) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menu_item`
--

INSERT INTO `menu_item` (`item_id`, `course_id`, `name`, `image`, `price`) VALUES
(2, 2, 'Macarrones con Atún', 'images/menu_items/mi_5741d31511c1d.jpg', 2.5),
(3, 3, 'Flan de Huevo', 'images/menu_items/mi_5741c4b4d9115.jpg', 2),
(4, 4, 'Agua Bezoya', 'images/menu_items/mi_5741c504cdd7b.png', 1.5),
(56, 1, 'Spaghettis a la Carbonara', 'images/menu_items/mi_5741d2399d664.jpg', 3),
(57, 6, 'Pera', 'images/menu_items/mi_5741eb3bd71ec.jpg', 1.5),
(58, 1, 'Pollo con Patatas', 'images/menu_items/mi_5741ed6a4c655.jpeg', 3.5),
(59, 7, 'Vino Tinto de Jerez', 'images/menu_items/menuitem_5742fb42ef836.jpg', 5),
(60, 7, 'Vino de la Rioja', 'images/menu_items/menuitem_5746cffb7ec80.jpg', 7.5),
(61, 2, 'Salmón a la plancha', 'images/menu_items/menuitem_574cab1b8c853.jpg', 19),
(62, 1, 'Sopa de Cebolla', 'images/menu_items/menuitem_574cabb666766.jpg', 20);

-- --------------------------------------------------------

--
-- Table structure for table `menu_item_has_ingredient`
--

CREATE TABLE `menu_item_has_ingredient` (
  `menu_item_id` int(11) NOT NULL,
  `ingredient_id` int(11) NOT NULL,
  `quantity` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menu_item_has_ingredient`
--

INSERT INTO `menu_item_has_ingredient` (`menu_item_id`, `ingredient_id`, `quantity`) VALUES
(2, 5, 0),
(2, 19, 0),
(2, 20, 0),
(2, 30, 0),
(3, 2, 0),
(3, 3, 0),
(4, 34, 0),
(60, 34, 0),
(61, 31, 0),
(61, 37, 0),
(62, 5, 0),
(62, 10, 0),
(62, 15, 0),
(62, 30, 0),
(62, 31, 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `table_id` int(11) NOT NULL,
  `chef_id` int(11) NOT NULL,
  `waiter_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `total_price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `status_id`, `table_id`, `chef_id`, `waiter_id`, `client_id`, `menu_id`, `order_date`, `total_price`) VALUES
(30, 1, 5, 1, 1, 1, 68, '2016-05-30 21:26:33', 8.5);

-- --------------------------------------------------------

--
-- Table structure for table `restaurant`
--

CREATE TABLE `restaurant` (
  `restaurant_id` int(11) NOT NULL,
  `CIF` varchar(9) NOT NULL,
  `name` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone1` int(9) NOT NULL,
  `phone2` int(9) DEFAULT NULL,
  `address` varchar(75) NOT NULL,
  `city` varchar(30) NOT NULL,
  `zip_code` varchar(6) NOT NULL,
  `description` varchar(160) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `restaurant`
--

INSERT INTO `restaurant` (`restaurant_id`, `CIF`, `name`, `email`, `phone1`, `phone2`, `address`, `city`, `zip_code`, `description`) VALUES
(1, 'C12345678', 'Cafeteria Provensana', 'cafeteriaprov@provensana.com', 938877645, 654387691, 'c/ Sant Pius X 8', 'Hospitalet de Llobregat', '08908', 'The best cafeteria in Hospitalet de Llobregat. Visit Us!');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `food_quality` int(11) NOT NULL,
  `menu_variety` int(11) NOT NULL,
  `customer_treatment` int(11) NOT NULL,
  `cleaniless` int(11) NOT NULL,
  `pricing` int(11) NOT NULL,
  `local_location` int(11) NOT NULL,
  `waiting_time` int(11) NOT NULL,
  `observations` varchar(120) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `client_id`, `restaurant_id`, `food_quality`, `menu_variety`, `customer_treatment`, `cleaniless`, `pricing`, `local_location`, `waiting_time`, `observations`) VALUES
(1, 5, 1, 1, 1, 4, 1, 9, 6, 7, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis tempus ornare porta. Sed vehicula finibus orci, sit amet s'),
(2, 5, 1, 1, 8, 10, 5, 8, 3, 10, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis tempus ornare porta. Sed vehicula finibus orci, sit amet s'),
(3, 2, 1, 7, 3, 9, 4, 1, 1, 7, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis tempus ornare porta. Sed vehicula finibus orci, sit amet s'),
(4, 3, 1, 5, 2, 2, 7, 8, 7, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis tempus ornare porta. Sed vehicula finibus orci, sit amet s'),
(5, 5, 1, 5, 10, 7, 10, 9, 9, 2, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis tempus ornare porta. Sed vehicula finibus orci, sit amet s'),
(6, 3, 1, 5, 2, 3, 9, 1, 9, 9, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis tempus ornare porta. Sed vehicula finibus orci, sit amet s'),
(7, 2, 1, 3, 3, 3, 10, 1, 7, 10, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis tempus ornare porta. Sed vehicula finibus orci, sit amet s'),
(8, 4, 1, 6, 9, 4, 6, 7, 5, 10, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis tempus ornare porta. Sed vehicula finibus orci, sit amet s'),
(9, 2, 1, 1, 8, 6, 1, 3, 5, 8, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis tempus ornare porta. Sed vehicula finibus orci, sit amet s'),
(10, 1, 1, 3, 4, 9, 2, 4, 1, 2, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis tempus ornare porta. Sed vehicula finibus orci, sit amet s');

-- --------------------------------------------------------

--
-- Table structure for table `status_order`
--

CREATE TABLE `status_order` (
  `status_id` int(11) NOT NULL,
  `name_status` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `status_order`
--

INSERT INTO `status_order` (`status_id`, `name_status`) VALUES
(1, 'BEING PREPARED'),
(2, 'SERVED'),
(3, 'PREPARED'),
(4, 'FINISHED');

-- --------------------------------------------------------

--
-- Table structure for table `tables_restaurant`
--

CREATE TABLE `tables_restaurant` (
  `table_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `table_status` int(11) NOT NULL,
  `table_location` int(11) NOT NULL,
  `capacity` int(11) NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tables_restaurant`
--

INSERT INTO `tables_restaurant` (`table_id`, `type_id`, `table_status`, `table_location`, `capacity`, `active`) VALUES
(1, 4, 2, 2, 2, 1),
(2, 2, 2, 3, 3, 1),
(3, 5, 2, 1, 2, 1),
(4, 3, 2, 1, 4, 1),
(5, 3, 1, 1, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `table_locations`
--

CREATE TABLE `table_locations` (
  `location_id` int(11) NOT NULL,
  `name_location` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `table_locations`
--

INSERT INTO `table_locations` (`location_id`, `name_location`) VALUES
(1, 'Window'),
(2, 'Terrace'),
(3, 'Toilet Near'),
(4, 'Lounge area');

-- --------------------------------------------------------

--
-- Table structure for table `table_status`
--

CREATE TABLE `table_status` (
  `table_status_id` int(11) NOT NULL,
  `name_status` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `table_status`
--

INSERT INTO `table_status` (`table_status_id`, `name_status`) VALUES
(1, 'Occupied'),
(2, 'Free');

-- --------------------------------------------------------

--
-- Table structure for table `table_types`
--

CREATE TABLE `table_types` (
  `type_id` int(11) NOT NULL,
  `name_type` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `table_types`
--

INSERT INTO `table_types` (`type_id`, `name_type`) VALUES
(2, 'Friends'),
(3, 'Family'),
(4, 'One Person'),
(5, 'Far from toilet');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(15) NOT NULL,
  `user_password` varchar(320) NOT NULL,
  `user_name` varchar(25) NOT NULL,
  `surname` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` int(9) NOT NULL,
  `address` varchar(75) NOT NULL,
  `city` varchar(30) NOT NULL,
  `zip_code` varchar(6) NOT NULL,
  `image` varchar(120) NOT NULL,
  `register_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `role` int(11) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1',
  `token` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `user_password`, `user_name`, `surname`, `email`, `phone`, `address`, `city`, `zip_code`, `image`, `register_date`, `role`, `active`, `token`) VALUES
(1, 'cliente1', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Antonio', 'Viva', 'antonio_viva@gmail.com', 929517457, 'AV. 20 DE NOVIEMBRE NO. 1060', 'Abrera', '08630', 'images/users/cliente1.gif', '2016-05-12 08:33:13', 0, 1, 'fd305e00283c1deab9e70fba967b9006'),
(2, 'cliente2', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Jose', 'De Santana', 'jose_de santana@gmail.com', 990811549, 'CALLE ZARAGOZA NO. 1010', 'Olesa', '08631', 'images/users/user.jpg', '2016-05-12 08:33:13', 0, 1, 'c8371081f7b483279e7966ded7532fc4'),
(3, 'cliente3', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Manuel', 'Famadas', 'manuel_famadas@gmail.com', 998481814, 'CALLE MATAMOROS NO. 310', 'Esparreguera', '08632', 'images/users/user.jpg', '2016-05-12 08:33:13', 0, 1, 'bff6326988b156af9ba93fb9f3437f31'),
(4, 'cliente4', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Francisco', 'De Toledo', 'francisco_de toledo@gmail.com', 925633261, 'AV. 20 DE NOVIEMBRE NO.859-B', 'Barcelona', '08633', 'images/users/user.jpg', '2016-05-12 08:33:13', 0, 1, 'd97d556cf71c424363550acb3321f573'),
(5, 'cliente5', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Juan', 'Malaguilla', 'juan_malaguilla@gmail.com', 970964859, 'AV. 20 DE NOVIEMBRE NO 1053', 'Sant Feliu de Llobregat', '08634', 'images/users/user.jpg', '2016-05-12 08:33:13', 0, 1, 'fc393526e593aa7ca6055eae7a3e7e5d'),
(6, 'chef1', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'David', 'Gasquet', 'david_gasquet@gmail.com', 972747022, 'BLVD. BENITO JUAREZ NO. 1466-A', 'Sant Boi de Llobregat', '08635', 'images/users/user.jpg', '2016-05-12 08:33:13', 1, 1, '5df50d56d4599eaddff48ed8abfee02a'),
(7, 'chef2', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Jose Antonio', 'Rujano', 'joseantonio_rujano@gmail.com', 950989462, 'CALLE MATAMOROS NO.280', 'Barcelona', '08636', 'images/users/user.jpg', '2016-05-12 08:33:13', 1, 1, 'facbac86be2ecd56cb07b89c188feecb'),
(8, 'chef3', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Jose Luis', 'Auza', 'jose luis_auza@gmail.com', 910580201, 'AV. INDEPENDENCIA NO. 545', 'Madrid', '08637', 'images/users/user.jpg', '2016-05-12 08:33:13', 1, 1, '13b37279c8670461ba699dd2d262b379'),
(9, 'chef4', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Javier', 'Ancizar', 'javier_ancizar@gmail.com', 903392768, 'AV. INDEPENDENCIA NO. 1282-A', 'Badalona', '08638', 'images/users/user.jpg', '2016-05-12 08:33:13', 1, 1, '38596d028d6545e43f12a8d88195b9cd'),
(10, 'chef5', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Francisco Javier', 'Peralias', 'francisco javier_peralias@gmail.com', 949307178, 'CALLE MATAMOROS NO. 127', 'Tarragona', '08639', 'images/users/user.jpg', '2016-05-12 08:33:14', 1, 1, '1fb1b3ef93abccc239417cdf7af1f33f'),
(11, 'camarero1', '20eabe5d64b0e216796e834f52d61fd0b70332fc', 'Maria Carmen', 'Barjacoba', 'maria carmen_barjacoba@gmail.com', 938015077, 'AV.INDEPENDENCIA NO.1010', 'Manresa', '08640', 'images/users/user.jpg', '2016-05-12 08:33:14', 2, 1, '242e14f31079233312bb0922ccd9e61d'),
(12, 'camarero2', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Maria', 'Villafuertes', 'maria_villafuertes@gmail.com', 980288669, 'AV. 5 DE MAYO NO. 1652', 'Monistrol', '08641', 'images/users/user.jpg', '2016-05-12 08:33:14', 2, 1, 'b83aa947631791833a09d813da8c21eb'),
(13, 'camarero3', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Carmen', 'Boher', 'carmen_boher@gmail.com', 914847503, 'AV. 5 DE MAYO NO. 1108', 'Sant Vicenç', '08642', 'images/users/user.jpg', '2016-05-12 08:33:14', 2, 1, 'a7f1eaba504895cf5a5fd9b49a2d9736'),
(14, 'camarero4', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Josefa', 'Danus', 'josefa_danus@gmail.com', 993877669, 'AV. INDEPENDENCIA NO. 748', 'Sant Andreu de la Barca', '08643', 'images/users/user.jpg', '2016-05-12 08:33:14', 2, 1, 'cd0f99775fe70d57c30f8abe38d7bcc0'),
(15, 'camarero5', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Isabel', 'Callon', 'isabel_callon@gmail.com', 903105576, 'AV. INDEPENDENCIA NO. 985-A', 'Pallejà', '08644', 'images/users/user.jpg', '2016-05-12 08:33:14', 2, 1, '94cf37199112f7a1990c21b4844d9af2'),
(16, 'admin1', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Victor', 'Moreno García', 'victorabrera@gmail.com', 937700850, 'AV. INDEPENDENCIA NO. 985-A', 'Cornellà de Llobregat', '08645', 'images/users/admin1.jpg', '2016-05-12 08:33:14', 3, 1, '9bd78c27a491d22bf61cc5ae9107da5c'),
(17, 'admin2', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Maria Pilar', 'Maseres', 'maria pilar_maseres@gmail.com', 956350172, 'BLVD. BENITO JUAREZ S / N', 'Martorell', '08646', 'images/users/user.jpg', '2016-05-12 08:33:14', 3, 1, 'bc3ae1d4e858af69b27eeb7dfa70ff66'),
(18, 'admin3', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Maria Dolores', 'Deleito', 'maria dolores_deleito@gmail.com', 924054260, 'MATAMOROS NO 149', 'Bilbao', '08647', 'images/users/user.jpg', '2016-05-12 08:33:14', 3, 1, '6bf3c008ad908875111e4087c7ffc75c'),
(19, 'admin4', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Maria Teresa', 'Ergueta', 'maria teresa_ergueta@gmail.com', 950380009, 'AV. 5 DE MAYO NO 1100-A', 'Molins de Rey', '08648', 'images/users/user.jpg', '2016-05-12 08:33:14', 3, 1, '64a5988dcf64fabd008bdfbb752d8b4a'),
(20, 'admin5', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Ana', 'Sastriques', 'ana_sastriques@gmail.com', 969370947, 'AV. 20 DE NOVIEMBRE NO 1540', 'Callús', '08649', 'images/users/user.jpg', '2016-05-12 08:33:14', 3, 1, 'fa1d82680f512de45a8060b9d9acf3d5');

-- --------------------------------------------------------

--
-- Table structure for table `waiter`
--

CREATE TABLE `waiter` (
  `user_id` int(11) NOT NULL,
  `waiter_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `waiter`
--

INSERT INTO `waiter` (`user_id`, `waiter_id`) VALUES
(11, 1),
(12, 2),
(13, 3),
(14, 4),
(15, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `chef`
--
ALTER TABLE `chef`
  ADD PRIMARY KEY (`chef_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`client_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `ingredient`
--
ALTER TABLE `ingredient`
  ADD PRIMARY KEY (`ingredient_id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `menu_has_item`
--
ALTER TABLE `menu_has_item`
  ADD PRIMARY KEY (`menu_id`,`item_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `menu_item`
--
ALTER TABLE `menu_item`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `menu_item_has_ingredient`
--
ALTER TABLE `menu_item_has_ingredient`
  ADD PRIMARY KEY (`menu_item_id`,`ingredient_id`),
  ADD KEY `ingredient_id` (`ingredient_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `table_id` (`table_id`),
  ADD KEY `chef_id` (`chef_id`),
  ADD KEY `waiter_id` (`waiter_id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `menu_id` (`menu_id`);

--
-- Indexes for table `restaurant`
--
ALTER TABLE `restaurant`
  ADD PRIMARY KEY (`restaurant_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `restaurant_id` (`restaurant_id`);

--
-- Indexes for table `status_order`
--
ALTER TABLE `status_order`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `tables_restaurant`
--
ALTER TABLE `tables_restaurant`
  ADD PRIMARY KEY (`table_id`),
  ADD KEY `type_id` (`type_id`),
  ADD KEY `table_status` (`table_status`),
  ADD KEY `table_location` (`table_location`);

--
-- Indexes for table `table_locations`
--
ALTER TABLE `table_locations`
  ADD PRIMARY KEY (`location_id`);

--
-- Indexes for table `table_status`
--
ALTER TABLE `table_status`
  ADD PRIMARY KEY (`table_status_id`);

--
-- Indexes for table `table_types`
--
ALTER TABLE `table_types`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `waiter`
--
ALTER TABLE `waiter`
  ADD PRIMARY KEY (`waiter_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `chef`
--
ALTER TABLE `chef`
  MODIFY `chef_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `ingredient`
--
ALTER TABLE `ingredient`
  MODIFY `ingredient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;
--
-- AUTO_INCREMENT for table `menu_item`
--
ALTER TABLE `menu_item`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `restaurant`
--
ALTER TABLE `restaurant`
  MODIFY `restaurant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `status_order`
--
ALTER TABLE `status_order`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tables_restaurant`
--
ALTER TABLE `tables_restaurant`
  MODIFY `table_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `table_locations`
--
ALTER TABLE `table_locations`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `table_status`
--
ALTER TABLE `table_status`
  MODIFY `table_status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `table_types`
--
ALTER TABLE `table_types`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `waiter`
--
ALTER TABLE `waiter`
  MODIFY `waiter_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `admins_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `chef`
--
ALTER TABLE `chef`
  ADD CONSTRAINT `chef_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `client_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `menu_has_item`
--
ALTER TABLE `menu_has_item`
  ADD CONSTRAINT `menu_has_item_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`menu_id`),
  ADD CONSTRAINT `menu_has_item_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `menu_item` (`item_id`);

--
-- Constraints for table `menu_item`
--
ALTER TABLE `menu_item`
  ADD CONSTRAINT `menu_item_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`);

--
-- Constraints for table `menu_item_has_ingredient`
--
ALTER TABLE `menu_item_has_ingredient`
  ADD CONSTRAINT `menu_item_has_ingredient_ibfk_1` FOREIGN KEY (`menu_item_id`) REFERENCES `menu_item` (`item_id`),
  ADD CONSTRAINT `menu_item_has_ingredient_ibfk_2` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredient` (`ingredient_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `status_order` (`status_id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`table_id`) REFERENCES `tables_restaurant` (`table_id`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`chef_id`) REFERENCES `chef` (`chef_id`),
  ADD CONSTRAINT `orders_ibfk_4` FOREIGN KEY (`waiter_id`) REFERENCES `waiter` (`waiter_id`),
  ADD CONSTRAINT `orders_ibfk_5` FOREIGN KEY (`client_id`) REFERENCES `client` (`client_id`),
  ADD CONSTRAINT `orders_ibfk_6` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`menu_id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurant` (`restaurant_id`);

--
-- Constraints for table `tables_restaurant`
--
ALTER TABLE `tables_restaurant`
  ADD CONSTRAINT `tables_restaurant_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `table_types` (`type_id`),
  ADD CONSTRAINT `tables_restaurant_ibfk_2` FOREIGN KEY (`table_status`) REFERENCES `table_status` (`table_status_id`),
  ADD CONSTRAINT `tables_restaurant_ibfk_3` FOREIGN KEY (`table_location`) REFERENCES `table_locations` (`location_id`);

--
-- Constraints for table `waiter`
--
ALTER TABLE `waiter`
  ADD CONSTRAINT `waiter_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
