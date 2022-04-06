-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 29, 2020 at 05:45 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `imageeditor`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `forgot_token` varchar(250) NOT NULL,
  `forgot_token_expire_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `email`, `password`, `forgot_token`, `forgot_token_expire_date`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$6Z2zWYvbAEjFTJPoZ2r1V.DmXRWdjt9zpOIPnZRHRFVVqmT2i1YR6', '71f69ea0ab20185e732f4167a449f2c2', '2020-07-27 11:48:29');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `icon` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `icon`) VALUES
(7, 'Backgrounds', '<i class=\"fas fa-images\"></i>'),
(11, 'Clip Arts', '<i class=\"far fa-sun\"></i>'),
(14, 'Emojis', '<i class=\"far fa-grin-hearts\"></i>'),
(15, 'Icons', '<i class=\"fab fa-connectdevelop\"></i>');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `src` varchar(250) NOT NULL,
  `type` varchar(20) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `name`, `src`, `type`, `category_id`) VALUES
(1, 'defocused image of lights', '732147f7b43245f7a2eb086cb9732a051.jpeg', '', 7),
(2, 'background brick wall bricks brickwork', '732147f7b43245f7a2eb086cb9732a052.jpeg', '', 7),
(4, 'yellow bokeh photo', '3eda1991b565cb18ce75028e645247f84.jpeg', '', 7),
(5, 'background blur clean clear', '2e234f69090faff927e262c1791ecf9e5.jpeg', '', 7),
(6, 'blue and purple cosmic sky', '2e234f69090faff927e262c1791ecf9e6.jpeg', '', 7),
(7, 'abstract ancient antique art', 'ab194e30b68a65f536042ef516dd06d57.jpeg', '', 7),
(10, 'assorted color sequins', 'bc520fd0c2c85a67e07accc69aa3b89610.jpeg', '', 7),
(12, 'close up of wooden plank', '6e8c284eb4d5592e78d25621cbd4f53b2.jpeg', '', 7),
(13, 'green tree beside seashore near green mountain', '6e8c284eb4d5592e78d25621cbd4f53b3.jpeg', '', 7),
(16, 'background blur bokeh bright', '75560b89cd3ba1ca390783b10457c5ae6.jpeg', '', 7),
(17, 'closeup photo of brown brick wall', '75560b89cd3ba1ca390783b10457c5ae7.jpeg', '', 7),
(22, 'black textile', 'b4dadda4de92ef27fb760cd8eb638efd2.jpeg', '', 7),
(23, 'stack of love wooden blocks', '2fc8df781ea66b5072d28dd32a8455b23.jpeg', '', 7),
(24, 'adventure alps background beautiful', '2fc8df781ea66b5072d28dd32a8455b24.jpeg', '', 7),
(25, 'person on a bridge near a lake', '49cb2ef5bc001b6e86ff6d91c5064feb5.jpeg', '', 7),
(26, 'k wallpaper background blur blurred background', 'c8d1fc9852ceb52787166be0da9e16b46.jpeg', '', 7),
(27, 'close up of tree against sky', 'd6422802f5575cd9463010f75dfa4af77.jpeg', '', 7),
(28, 'background cement concrete paint', 'd6422802f5575cd9463010f75dfa4af78.jpeg', '', 7),
(29, 'abstract art background blue', 'fc80e755b74409a001a55b839f93ee1f9.jpeg', '', 7),
(31, 'background beautiful bloom blooming', 'a93f952268cf901774244e3f33921f0e1.jpeg', '', 7),
(32, 'multicolored abstract painting', 'a93f952268cf901774244e3f33921f0e2.jpeg', '', 7),
(33, 'red wooden surface', '8b37cb94c544822ca268456b150624b33.jpeg', '', 7),
(34, 'assorted leaves piled on border of brown wooden board', '8b37cb94c544822ca268456b150624b34.jpeg', '', 7),
(35, 'atmosphere background bright clouds', '16aea7dfc5130a20530182306bdaadd05.jpeg', '', 7),
(36, 'multicolored abstract painting', 'cd3b8d882277af63b219b466c87b0e836.jpeg', '', 7),
(37, 'afterglow background beautiful branches', 'cd3b8d882277af63b219b466c87b0e837.jpeg', '', 7),
(39, 'pink clouds', '9dc03dc4de463998a3284a22dc6134679.jpeg', '', 7),
(40, 'abstract art artistic background', '0c0e4b1da9b5dea3a8d07c76cd43922c10.jpeg', '', 7),
(41, 'white headphone', '0c0e4b1da9b5dea3a8d07c76cd43922c11.jpeg', '', 7),
(42, 'aerial photo of mountain surrounded by fog', '29fcf938129549207550b7773501d60e12.jpeg', '', 7),
(43, 'white and black wooden board', 'dec527494e47907f7ae52a0feb107d0613.jpeg', '', 7),
(44, 'gray concrete roadway beside green and brown leafed trees', 'afa14816008a0fd844b268d17f62ff2b14.jpeg', '', 7),
(45, 'background beautiful blossom calm waters', 'fd24f996f4ee9a1419c4e73a4b30d51215.jpeg', '', 7),
(47, 'background blank empty light', 'dd8709ac1c65474931bdf1452fdcf4ca17.jpeg', '', 7),
(48, 'landscape photography of sea shore', '8e9dc73a825e4a61c2bcdf6f53a2cfa018.jpeg', '', 7),
(49, 'wall bricks', 'fc53ba86b3150019d292ce52c41b153819.jpeg', '', 7),
(51, 'white sky', 'a46417906fb2dab5efa95c2d650bd97c1.jpeg', '', 7),
(52, 'background backlight blur color', 'a46417906fb2dab5efa95c2d650bd97c2.jpeg', '', 7),
(57, 'backdrop background orange rough', 'fc290347ac664342aa432968ab6fefa37.jpeg', '', 7),
(58, 'above ground photo of succulent plants on brown wooden board', 'dff4569444ca217b9775a153000515288.jpeg', '', 7),
(59, 'close up of hand holding pencil over white background', '490fba38ffb8d672cf2ac5e15e4f56b29.jpeg', '', 7),
(60, 'abstract art background blur', 'db29e5140b26e51f49a2546ba5df0b3610.jpeg', '', 7),
(61, 'blue green orange and red rainbow design decoration', '60566bcff90a6320bd6f58117409cbea11.jpeg', '', 7),
(62, 'background balance beach boulder', '43d76d876e2d6a06cd9ca635a0e128ec12.jpeg', '', 7),
(63, 'background creativity decoration design', 'a61bb90504e6e96333cfbe70e0eb2a0813.jpeg', '', 7),
(64, 'art background decoration light', '614e11b30b6307921d46e379628f72c914.jpeg', '', 7),
(65, 'blue and red galaxy artwork', 'e9efb98e2e764e7e893a25704df59a0a15.jpeg', '', 7),
(66, 'full frame shot of abstract background', 'e972ae5da4dddd77f52fac9798fb387a16.jpeg', '', 7),
(67, 'defocused image of illuminated lights at night', '3ff4938d2b2e430f74e89c8291ddd00e17.jpeg', '', 7),
(68, 'atmosphere background beautiful blue', 'a3d419367c334eee7787086e8bca065918.jpeg', '', 7),
(69, 'abstract art background bokeh', 'a3d419367c334eee7787086e8bca065919.jpeg', '', 7),
(70, 'abstract art artificial artistic', 'a221fad90450c45ef7e3519407e227e020.jpeg', '', 7),
(72, 'abstract antique backdrop background', '99580da91d2f4d2adfd84b9187c5b2ae22.jpeg', '', 7),
(73, 'abstract architecture background brick', 'd97b97def45c5ad80cea2995bf22db1f23.jpeg', '', 7),
(74, 'green flower bouquet on white background', 'b17d357121f3169db58bdec7feac032524.jpeg', '', 7),
(75, 'gray double bell clock', '0a9ae4c4e1eb42fc3e4ee2de04ae1b6f25.jpeg', '', 7),
(76, 'landscape photo of road in the middle of mountains', '0a9ae4c4e1eb42fc3e4ee2de04ae1b6f26.jpeg', '', 7),
(77, 'timelapse photography of falls near trees', '375adfe57b30dea6e0c27457c3ad7d5b27.jpeg', '', 7),
(78, 'background blade blur bokeh', '67d091c462bae840eceadaf3ab4702c128.jpeg', '', 7),
(80, 'red lighted candle', '7a2a5cc6b0b3a60576ee8955627c949130.jpeg', '', 7),
(81, 'backdrop background orange rough', 'cf11229a06248bd1c01f50ff7bdcd7511.jpeg', '', 7),
(82, 'abstract art artistic background', 'cf11229a06248bd1c01f50ff7bdcd7512.jpeg', '', 7),
(84, 'purple petaled flower on white surface', 'e95fcd4ae73331863ddd21fdee3080cc4.jpeg', '', 7),
(87, 'abstract art artificial artistic', 'b69c637cdffd4854bd0325bff2224bc07.jpeg', '', 7),
(88, 'apple background desk electronics', '1869d325e34110f9ed52797eb54cb6c88.jpeg', '', 7),
(89, 'background cement concrete paint', '209786f4cc0bc9fc4d321b0273421ed89.jpeg', '', 7),
(92, 'bloom book botanical cactus', 'f9a487c4da1a314d0532253a2096e62612.jpeg', '', 7),
(99, 'two pink ballpoint pens on table', 'cce62782a5c46211c3bcaeafcffd31ba19.jpeg', '', 7),
(330, 'pirate funny face', '1beb2bfad9a321dd8cc5232cca7c24bb0.png', '', 11),
(331, 'christmas face', '9170938b4d1c25eae61cce12a96b9ac40.png', '', 11),
(332, 'Funny face Student', 'af71cad3666f79dae5737f8b751a6b0f0.png', '', 11),
(333, 'Funny face Evil', 'af71cad3666f79dae5737f8b751a6b0f1.png', '', 11),
(334, 'Funny face with glasses', 'af71cad3666f79dae5737f8b751a6b0f2.png', '', 11),
(335, 'Funny face Angry', 'af71cad3666f79dae5737f8b751a6b0f3.png', '', 11),
(336, 'Funny face Happy', 'af71cad3666f79dae5737f8b751a6b0f4.png', '', 11),
(337, 'funny face no emotions', 'a152c106f1845bacf4c5467851446f110.png', '', 11),
(338, 'funny face oh no', 'a152c106f1845bacf4c5467851446f111.png', '', 11),
(339, 'Boy', 'ed9434aca7386fae52d6017fa5a819f00.png', '', 11),
(340, 'Girl', 'ed9434aca7386fae52d6017fa5a819f01.png', '', 11),
(341, 'Boy', 'ed9434aca7386fae52d6017fa5a819f02.png', '', 11),
(342, 'Girl', 'ed9434aca7386fae52d6017fa5a819f03.png', '', 11),
(343, 'Girl', 'ed9434aca7386fae52d6017fa5a819f04.png', '', 11),
(344, 'Girl', 'a77fc40f7363bfc369c07801a1a8c5040.png', '', 11),
(345, 'Girl', 'a77fc40f7363bfc369c07801a1a8c5041.png', '', 11),
(346, 'Girl', 'a77fc40f7363bfc369c07801a1a8c5042.png', '', 11),
(347, 'Girl', 'a77fc40f7363bfc369c07801a1a8c5043.png', '', 11),
(350, 'Girl Standing', 'c0dcfbfb025a1661913b27bad3d6cc881.png', '', 11),
(355, 'Human Girl Boy Standing', '76ad4a1a80b90aec7fba49ed0df2767d1.png', '', 11),
(356, 'Boy with hat', '76ad4a1a80b90aec7fba49ed0df2767d2.png', '', 11),
(390, 'Fruit', '8f88f8da2ff369c66e7f090a329900660.png', '', 11),
(391, 'Fruit', '8f88f8da2ff369c66e7f090a329900661.png', '', 11),
(392, 'Fruit', '8f88f8da2ff369c66e7f090a329900662.png', '', 11),
(393, 'Fruit', '8f88f8da2ff369c66e7f090a329900663.png', '', 11),
(394, 'Fruit', '8f88f8da2ff369c66e7f090a329900664.png', '', 11),
(395, 'Fruits', '151d731b5ccb9212b8c33b95b56334270.png', '', 11),
(396, 'Fruits', '151d731b5ccb9212b8c33b95b56334271.png', '', 11),
(397, 'Fruits', '151d731b5ccb9212b8c33b95b56334272.png', '', 11),
(398, 'Fruits', '151d731b5ccb9212b8c33b95b56334273.png', '', 11),
(399, 'Fruits', 'c73c705bb00e4d98479becf39824abda4.png', '', 11),
(400, 'Fruits', 'a74a3dc4ce92697ee1668991ba36e9380.png', '', 11),
(401, 'Fruits', 'a74a3dc4ce92697ee1668991ba36e9381.png', '', 11),
(402, 'Fruits', 'a74a3dc4ce92697ee1668991ba36e9382.png', '', 11),
(403, 'Corona Virus', 'feb94da76dd1fdbad77423f6f07dc9310.png', '', 11),
(404, 'Corona Virus', 'feb94da76dd1fdbad77423f6f07dc9311.png', '', 11),
(405, 'Corona Virus', 'feb94da76dd1fdbad77423f6f07dc9312.png', '', 11),
(406, 'Corona Virus', 'feb94da76dd1fdbad77423f6f07dc9313.png', '', 11),
(407, 'Animals', '7d01c1bd4b63ec51bd77e6aa369cfa480.png', '', 11),
(408, 'Animals', '7d01c1bd4b63ec51bd77e6aa369cfa481.png', '', 11),
(409, 'Animals', '7d01c1bd4b63ec51bd77e6aa369cfa482.png', '', 11),
(410, 'Animals', '7d01c1bd4b63ec51bd77e6aa369cfa483.png', '', 11),
(411, 'Animals', '7d01c1bd4b63ec51bd77e6aa369cfa484.png', '', 11),
(412, 'Animals', '30abe58bdee2cae126da445ef80b4b950.png', '', 11),
(413, 'Animals', '30abe58bdee2cae126da445ef80b4b951.png', '', 11),
(414, 'Animals', '30abe58bdee2cae126da445ef80b4b952.png', '', 11),
(415, 'Animals', '30abe58bdee2cae126da445ef80b4b953.png', '', 11),
(416, 'Animals', '30abe58bdee2cae126da445ef80b4b954.png', '', 11),
(417, 'cars', '7fa3c84143e44937b4b4eedbedd5fcdd0.png', '', 11),
(418, 'Crain JCB', '7fa3c84143e44937b4b4eedbedd5fcdd1.png', '', 11),
(419, 'cars', '7fa3c84143e44937b4b4eedbedd5fcdd2.png', '', 11),
(420, 'Crain JCB', '7fa3c84143e44937b4b4eedbedd5fcdd3.png', '', 11),
(421, 'Motor Bike Motor Cycle', '8a81f6d8945610a993b49d3f020db0cf4.png', '', 11),
(422, 'helicopter Airplane', 'b18360cfc792232214b319b7d13060f80.png', '', 11),
(423, 'helicopter Airplane', 'b18360cfc792232214b319b7d13060f81.png', '', 11),
(424, 'School Bus', 'b18360cfc792232214b319b7d13060f82.png', '', 11),
(425, 'helicopter Airplane', '2b073b6fa6b5a4661a7d468c1caf2fea3.png', '', 11),
(426, 'helicopter Airplane', '2b073b6fa6b5a4661a7d468c1caf2fea4.png', '', 11),
(427, 'Frames', 'e36afce78236adaad5c5e75a29d392770.png', '', 11),
(428, 'Frames', 'e36afce78236adaad5c5e75a29d392771.png', '', 11),
(429, 'Frames', 'e36afce78236adaad5c5e75a29d392772.png', '', 11),
(430, 'Frames', 'e36afce78236adaad5c5e75a29d392773.png', '', 11),
(431, 'Coulds', 'e36afce78236adaad5c5e75a29d392774.png', '', 11),
(432, 'Blue Emojis', '619b47826cf07160d0e074730743e5a30.png', '', 14),
(433, 'Blue Emojis', '619b47826cf07160d0e074730743e5a31.png', '', 14),
(434, 'Blue Emojis', '619b47826cf07160d0e074730743e5a32.png', '', 14),
(435, 'Blue Emojis', '619b47826cf07160d0e074730743e5a33.png', '', 14),
(436, 'Blue Emojis', '619b47826cf07160d0e074730743e5a34.png', '', 14),
(437, 'Blue Emojis', '2f2e351497129279aa9767d4c9e4681a0.png', '', 14),
(438, 'Blue Emojis', '2f2e351497129279aa9767d4c9e4681a1.png', '', 14),
(439, 'Blue Emojis', '2f2e351497129279aa9767d4c9e4681a2.png', '', 14),
(440, 'Blue Emojis', '2f2e351497129279aa9767d4c9e4681a3.png', '', 14),
(441, 'Blue Emojis', '2f2e351497129279aa9767d4c9e4681a4.png', '', 14),
(442, 'Blue Emojis', '61a1f026f6592f8fe3ec247832093b0e0.png', '', 14),
(443, 'Blue Emojis', '61a1f026f6592f8fe3ec247832093b0e1.png', '', 14),
(444, 'Blue Emojis', '61a1f026f6592f8fe3ec247832093b0e2.png', '', 14),
(445, 'Blue Emojis', '61a1f026f6592f8fe3ec247832093b0e3.png', '', 14),
(446, 'Blue Emojis', '61a1f026f6592f8fe3ec247832093b0e4.png', '', 14),
(447, 'Blue Emojis', '1bc28e0d942cea4c665ff8fdbddba4d40.png', '', 14),
(448, 'Blue Emojis', '1bc28e0d942cea4c665ff8fdbddba4d41.png', '', 14),
(449, 'Blue Emojis', '1bc28e0d942cea4c665ff8fdbddba4d42.png', '', 14),
(450, 'Blue Emojis', '1bc28e0d942cea4c665ff8fdbddba4d43.png', '', 14),
(451, 'Blue Emojis', '1bc28e0d942cea4c665ff8fdbddba4d44.png', '', 14),
(452, 'Hearts', '130c60e312a1e78127e40511aee1b7840.png', '', 14),
(453, 'Hearts', '130c60e312a1e78127e40511aee1b7841.png', '', 14),
(454, 'Hearts', '130c60e312a1e78127e40511aee1b7842.png', '', 14),
(455, 'Hearts', '130c60e312a1e78127e40511aee1b7843.png', '', 14),
(456, 'Hearts', '130c60e312a1e78127e40511aee1b7844.png', '', 14),
(457, 'Circle', 'cfa2de65cd3fc1b00109915c564ff6c03.svg', '', 15),
(458, 'like', 'cfa2de65cd3fc1b00109915c564ff6c04.svg', '', 15),
(459, 'bookmark', '675f80d7f7e377a45409526943099e8d5.svg', '', 15),
(460, 'wall clock', '675f80d7f7e377a45409526943099e8d6.svg', '', 15),
(461, 'global', '675f80d7f7e377a45409526943099e8d7.svg', '', 15),
(462, 'network', '675f80d7f7e377a45409526943099e8d8.svg', '', 15),
(463, 'check', '675f80d7f7e377a45409526943099e8d9.svg', '', 15),
(464, 'star', '675f80d7f7e377a45409526943099e8d10.svg', '', 15),
(465, 'black back closed envelope shape', '675f80d7f7e377a45409526943099e8d11.svg', '', 15),
(466, 'verified', '675f80d7f7e377a45409526943099e8d12.svg', '', 15),
(467, 'heart', '675f80d7f7e377a45409526943099e8d13.svg', '', 15),
(468, 'star', '675f80d7f7e377a45409526943099e8d14.svg', '', 15),
(469, 'favorite', '52101c93301da68dbb0bb8db3fc96acf15.svg', '', 15),
(470, 'share', '52101c93301da68dbb0bb8db3fc96acf16.svg', '', 15),
(471, 'add', '52101c93301da68dbb0bb8db3fc96acf17.svg', '', 15),
(472, 'search', '52101c93301da68dbb0bb8db3fc96acf18.svg', '', 15),
(473, 'smartphone', '52101c93301da68dbb0bb8db3fc96acf19.svg', '', 15),
(474, 'share', '52101c93301da68dbb0bb8db3fc96acf20.svg', '', 15),
(475, 'more', '52101c93301da68dbb0bb8db3fc96acf21.svg', '', 15),
(476, 'menu', '52101c93301da68dbb0bb8db3fc96acf22.svg', '', 15),
(477, 'close', '52101c93301da68dbb0bb8db3fc96acf23.svg', '', 15),
(478, 'gmail', '52101c93301da68dbb0bb8db3fc96acf24.svg', '', 15),
(479, 'bookmark', '52101c93301da68dbb0bb8db3fc96acf25.svg', '', 15),
(480, 'percent', '52101c93301da68dbb0bb8db3fc96acf26.svg', '', 15),
(481, 'gear', '52101c93301da68dbb0bb8db3fc96acf27.svg', '', 15),
(482, 'checkmark', '52101c93301da68dbb0bb8db3fc96acf28.svg', '', 15),
(483, 'share', '52101c93301da68dbb0bb8db3fc96acf29.svg', '', 15),
(484, 'wireless internet', '52101c93301da68dbb0bb8db3fc96acf30.svg', '', 15),
(485, 'clock', '179accfe1ae761fec4a6ef03f47dab5731.svg', '', 15),
(486, 'destination', '179accfe1ae761fec4a6ef03f47dab5732.svg', '', 15),
(487, 'dislike', '179accfe1ae761fec4a6ef03f47dab5733.svg', '', 15),
(488, 'bookmark', '179accfe1ae761fec4a6ef03f47dab5734.svg', '', 15),
(489, 'software', '179accfe1ae761fec4a6ef03f47dab5735.svg', '', 15),
(490, 'eye', '179accfe1ae761fec4a6ef03f47dab5736.svg', '', 15),
(491, 'wedding rin', '179accfe1ae761fec4a6ef03f47dab5737.svg', '', 15),
(492, 'key', '179accfe1ae761fec4a6ef03f47dab5738.svg', '', 15),
(493, 'bitcoin', '179accfe1ae761fec4a6ef03f47dab5739.svg', '', 15),
(494, 'mail', '179accfe1ae761fec4a6ef03f47dab5740.svg', '', 15),
(495, 'menu', '179accfe1ae761fec4a6ef03f47dab5741.svg', '', 15),
(496, 'gift', '179accfe1ae761fec4a6ef03f47dab5742.svg', '', 15),
(497, 'piggy bank', '179accfe1ae761fec4a6ef03f47dab5743.svg', '', 15),
(498, 'television', '179accfe1ae761fec4a6ef03f47dab5744.svg', '', 15),
(499, 'down arrow', '179accfe1ae761fec4a6ef03f47dab5745.svg', '', 15),
(500, 'money', '179accfe1ae761fec4a6ef03f47dab5746.svg', '', 15),
(501, 'group', '179accfe1ae761fec4a6ef03f47dab5747.svg', '', 15),
(502, 'picture', 'db6e50192e56e3e02b565f721a3ed7b248.svg', '', 15),
(503, 'drop', 'db6e50192e56e3e02b565f721a3ed7b249.svg', '', 15),
(504, 'pie chart', 'db6e50192e56e3e02b565f721a3ed7b250.svg', '', 15),
(505, 'credit card', 'db6e50192e56e3e02b565f721a3ed7b251.svg', '', 15),
(506, 'browser', 'db6e50192e56e3e02b565f721a3ed7b252.svg', '', 15),
(507, 'bank', 'db6e50192e56e3e02b565f721a3ed7b253.svg', '', 15),
(508, 'truck', 'db6e50192e56e3e02b565f721a3ed7b254.svg', '', 15),
(509, 'placeholder', 'db6e50192e56e3e02b565f721a3ed7b255.svg', '', 15),
(510, 'camera', 'db6e50192e56e3e02b565f721a3ed7b256.svg', '', 15),
(511, 'microphone', 'db6e50192e56e3e02b565f721a3ed7b257.svg', '', 15),
(517, 'Whatsapp Yellow Emojis', '9ab2773ea5f085387fd555420581d8da0.png', '', 14),
(518, 'Whatsapp Yellow Emojis', '9ab2773ea5f085387fd555420581d8da1.png', '', 14),
(519, 'Whatsapp Yellow Emojis', '9ab2773ea5f085387fd555420581d8da2.png', '', 14),
(520, 'Whatsapp Yellow Emojis', '9ab2773ea5f085387fd555420581d8da3.png', '', 14),
(521, 'Whatsapp Yellow Emojis', '5fe40c3c631257e3e22fb01df9584a354.png', '', 14),
(522, 'Whatsapp Yellow Emojis', '25dcb1848e4f93a602774ecedacc02240.png', '', 14),
(523, 'Whatsapp Yellow Emojis', '25dcb1848e4f93a602774ecedacc02241.png', '', 14),
(524, 'Whatsapp Yellow Emojis', '25dcb1848e4f93a602774ecedacc02242.png', '', 14),
(525, 'Whatsapp Yellow Emojis', '25dcb1848e4f93a602774ecedacc02243.png', '', 14),
(526, 'Whatsapp Yellow Emojis', '25dcb1848e4f93a602774ecedacc02244.png', '', 14),
(527, 'Whatsapp Yellow Emojis', '5930688710e2d72cfdf27820c5dd15ef0.png', '', 14),
(528, 'Whatsapp Yellow Emojis', '5930688710e2d72cfdf27820c5dd15ef1.png', '', 14),
(529, 'Whatsapp Yellow Emojis', '5930688710e2d72cfdf27820c5dd15ef2.png', '', 14),
(530, 'Whatsapp Yellow Emojis', '5930688710e2d72cfdf27820c5dd15ef3.png', '', 14),
(531, 'Whatsapp Yellow Emojis', '35d77486d97e2b9658622984764658154.png', '', 14),
(532, 'Whatsapp Yellow Emojis', 'b1cf53dd9ec7dc18393eaf0364dc0d800.png', '', 14),
(533, 'Whatsapp Yellow Emojis', 'b1cf53dd9ec7dc18393eaf0364dc0d801.png', '', 14),
(534, 'Whatsapp Yellow Emojis', 'b1cf53dd9ec7dc18393eaf0364dc0d802.png', '', 14),
(535, 'Whatsapp Yellow Emojis', 'b1cf53dd9ec7dc18393eaf0364dc0d803.png', '', 14),
(536, 'Whatsapp Yellow Emojis', 'b1cf53dd9ec7dc18393eaf0364dc0d804.png', '', 14),
(537, 'Whatsapp Yellow Emojis', 'e83b450ef7dd0621c529f3f9fa545a180.png', '', 14),
(538, 'Whatsapp Yellow Emojis', 'e83b450ef7dd0621c529f3f9fa545a181.png', '', 14),
(539, 'Whatsapp Yellow Emojis', 'e83b450ef7dd0621c529f3f9fa545a182.png', '', 14),
(540, 'Whatsapp Yellow Emojis', 'e83b450ef7dd0621c529f3f9fa545a183.png', '', 14),
(541, 'Whatsapp Yellow Emojis', 'e83b450ef7dd0621c529f3f9fa545a184.png', '', 14),
(542, 'Whatsapp Yellow Emojis', '6eccb56b9acd4d38722ea1eded14fae10.png', '', 14),
(543, 'Whatsapp Yellow Emojis', '6eccb56b9acd4d38722ea1eded14fae11.png', '', 14),
(544, 'Whatsapp Yellow Emojis', '6eccb56b9acd4d38722ea1eded14fae12.png', '', 14),
(545, 'Whatsapp Yellow Emojis', '6eccb56b9acd4d38722ea1eded14fae13.png', '', 14),
(546, 'Whatsapp Yellow Emojis', '6eccb56b9acd4d38722ea1eded14fae14.png', '', 14);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=547;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
