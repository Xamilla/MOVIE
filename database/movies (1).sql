-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 18, 2025 at 01:00 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `movies_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `movie_id` int(11) NOT NULL,
  `movie_name` varchar(255) DEFAULT NULL,
  `movie_summary` text NOT NULL,
  `movie_director` varchar(255) NOT NULL,
  `cast` varchar(255) NOT NULL,
  `categories` enum('comedy','fantasy','superheros') DEFAULT NULL,
  `price` int(11) NOT NULL,
  `duration` varchar(15) DEFAULT NULL,
  `movie_quantity` int(11) NOT NULL,
  `movie_picture` varchar(255) NOT NULL,
  `date_uploaded` timestamp NOT NULL DEFAULT current_timestamp(),
  `released` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`movie_id`, `movie_name`, `movie_summary`, `movie_director`, `cast`, `categories`, `price`, `duration`, `movie_quantity`, `movie_picture`, `date_uploaded`, `released`) VALUES
(1, 'Dear Santa', 'When a young boy mails his Christmas wish list to Santa with one crucial spelling error, a devilish Jack Black arrives to wreak havoc on the holidays.', 'Bobby Farrelly', 'Robert Timothy Smith as Liam Turner • Jack Black as Satan', 'comedy', 299, '2h', 12, 'dear-santa.jpg', '2025-03-12 07:54:06', '2025-03-10'),
(2, 'Fall Guy', 'After leaving the business one year earlier, battle-scarred stuntman Colt Seavers springs back into action when the star of a big studio movie suddenly disappears. As the mystery surrounding the missing actor deepens, Colt soon finds himself ensnared in a sinister plot that pushes him to the edge of a fall more dangerous than any stunt.', 'David Leitch', 'Ryan Gosling as Colt Seavers • Emily Blunt as Jody Moreno', 'comedy', 299, '8h', 80008, 'fall-guy.jpg', '2025-03-12 08:40:00', '2024-05-04'),
(3, 'Damsel', 'A young woman agrees to marry a handsome prince -- only to discover it was all a trap. She is thrown into a cave with a fire-breathing dragon and must rely solely on her wits and will to survive.', 'Juan Carlos Fresnadillo', ' Millie Bobby Brown as  Elodie • Ray Winstone as Lord Bayford', 'fantasy', 567, '1h 50m', 54, 'damsel.jpg', '2025-03-13 11:09:10', '2024-08-03'),
(4, 'In the Lost Lands', 'A witch travels to the Lost Lands in search of a magical power that allows a person to transform into a werewolf.', 'Paul W. S. Anderson', ' Milla Jovovich as Gray Alys • Dave Bautista as Boyce', 'fantasy', 400, '1h 42m', 56, 'lost-lands.jpg', '2025-03-14 19:03:21', '2025-03-06'),
(5, 'Star Dust', 'To win the heart of his beloved (Sienna Miller), a young man named Tristan (Charlie Cox) ventures into the realm of fairies to retrieve a fallen star. What Tristan finds, however, is not a chunk of space rock, but a woman (Claire Danes) named Yvaine. Yvaine is in great danger, for the king\'s sons need her powers to secure the throne, and an evil witch (Michelle Pfeiffer) wants to use her to achieve eternal youth and beauty.', 'Matthew Vaughn', 'Charlie Cox as Tristan • Claire Danes as Yvaine', 'fantasy', 542, '2h 7m', 435, 'startdust.jpg', '2025-03-14 19:03:21', '2007-10-10'),
(6, 'Superman: Man of Steel', 'With the imminent destruction of Krypton, their home planet, Jor-El (Russell Crowe) and his wife seek to preserve their race by sending their infant son to Earth. The child\'s spacecraft lands at the farm of Jonathan (Kevin Costner) and Martha (Diane Lane) Kent, who name him Clark and raise him as their own son. Though his extraordinary abilities have led to the adult Clark (Henry Cavill) living on the fringe of society, he finds he must become a hero to save those he loves from a dire threat.', 'Zack Snyder', 'Henry Cavill as Clark Kent •  Amy Adams as Lois Lane', 'superheros', 1100, '3h', 900, 'man-of-steel.jpg', '2025-03-13 03:00:21', '2013-06-12'),
(7, ' Aquaman and the Lost Kingdom', 'After failing to defeat Aquaman the first time, Black Manta wields the power of the mythic Black Trident to unleash an ancient and malevolent force. Hoping to end his reign of terror, Aquaman forges an unlikely alliance with his brother, Orm, the former king of Atlantis. Setting aside their differences, they join forces to protect their kingdom and save the world from irreversible destruction.', 'James Wan', 'Jason Momoa as Arthur • Patrick Wilson as Orm', 'superheros', 500, '1h 55m', 100, 'aquaman-and-the-lost-kingdom.jpg', '2025-03-13 10:32:52', '2023-12-22'),
(8, 'Dead Pool and Wolverine', 'Deadpool\'s peaceful existence comes crashing down when the Time Variance Authority recruits him to help safeguard the multiverse. He soon unites with his would-be pal, Wolverine, to complete the mission and save his world from an existential threat.', 'Shawn Levy', 'Ryan Reynolds as Wade Wilson • Hugh Jackman as Logan', 'superheros', 900, '2h 8m', 14, 'deadpool-and-wolverine.jpg', '2025-03-13 10:43:31', '2023-07-25'),
(11, 'White Chicks', 'Two FBI agent brothers, Marcus (Marlon Wayans) and Kevin Copeland (Shawn Wayans), accidentally foil a drug bust. As punishment, they are forced to escort a pair of socialites (Anne Dudek, Rochelle Aytes) to the Hamptons, where they\'re going to be used as bait for a kidnapper. But when the girls realize the FBI\'s plan, they refuse to go. Left without options, Marcus and Kevin decide to pose as the sisters, transforming themselves from African-American men into a pair of blonde, white women.', 'Keenen Ivory Wayans', 'Shawn Wayans as Kevin Copeland / Brittany Wilson • Marlon Wayans as Marcus Anthony Copeland II / Tiffany Wilson', 'comedy', 650, '1h 49m', 200, 'whitechiks.jpg', '2025-03-14 17:55:08', '2015-10-20'),
(12, 'Central Intelligence', 'Bullied as a teen for being overweight, Bob Stone (Dwayne Johnson) shows up to his high school reunion looking fit and muscular. While there, he finds Calvin Joyner (Kevin Hart), a fast-talking accountant who misses his glory days as a popular athlete. Stone is now a lethal CIA agent who needs Calvin\'s number skills to help him save the compromised U.S. spy satellite system. Together, the former classmates encounter shootouts, espionage and double-crosses while trying to prevent worldwide chaos.', 'Rawson Marshall Thurber', 'Dwayne Johnson as Bob Stone • Kevin Hart as Calvin Joyner', 'comedy', 800, '1h 56m', 30, 'central-intelligent.jpg', '2025-03-14 17:57:29', '2016-06-15'),
(13, 'Just Go with It', 'His heart recently broken, plastic surgeon Danny Maccabee (Adam Sandler) pretends to be married so he can enjoy future dates with no strings attached. His web of lies works, but when he meets Palmer (Brooklyn Decker) -- the gal of his dreams -- she resists involvement. Instead of coming clean, Danny enlists Katherine (Jennifer Aniston), his assistant, to pose as his soon-to-be-ex-wife. Instead of solving Danny\'s problems, the lies create more trouble.', 'Dennis Dugan', 'Adam Sandler as Dr. Daniel \"Danny\" Maccabee \r\n • Jennifer Aniston as Katherine Murphy ', 'comedy', 1500, '1h 57m', 23, 'just-go with-it.jpg', '2025-03-14 17:59:55', '2011-02-16'),
(14, 'Ride Alone', 'For two years, security guard Ben (Kevin Hart) has tried to convince James (Ice Cube), a veteran cop, that he is worthy of James\' sister, Angela. When Ben is finally accepted into the police academy, James decides to test his mettle by inviting him along on a shift deliberately designed to scare the trainee. However, events take an unexpected turn when their wild night leads to Atlanta\'s most-notorious criminal and Ben\'s rapid-fire mouth proves as dangerous as the bullets whizzing by them.', 'Tim Story', ' Ice Cube · James Payton • Kevin Hart as Ben Barber', 'comedy', 1000, '1h 40m', 5000, 'ride alone.jpg', '2025-03-14 18:16:01', '2025-01-17'),
(15, 'Our Little Secret', 'After discovering their significant others are siblings, two resentful exes must spend Christmas under one roof while hiding their romantic history.', 'Stephen Herek ', 'Lindsay Lohan as Avery • Ian Harding as Logan', 'comedy', 600, '1h 41m', 700, 'our-little-secret.jpg', '2025-03-14 18:16:01', '2024-11-24'),
(16, 'Killer\'s Game', 'Diagnosed with a terminal illness, top hit man Joe Flood decides to take matters into his own hands and take a hit out on himself. However, when the very men he hires also target his ex-girlfriend, he must fend off an army of assassins and win back the love of his life before it\'s too late.', 'J.J. Perry', 'Dave Bautista • Dmitrij Kalacsov • Mia Rouba • M.Kiss • Iván Orsány', 'comedy', 400, '1h 46m', 60, 'killer\'s-game.jpg', '2025-03-14 18:22:44', '2024-09-13'),
(17, 'Zootopia 2', 'Detectives Judy Hopps and Nick Wilde find themselves on the twisting trail of a mysterious reptile who arrives in Zootopia and turns the mammal metropolis upside down.', 'Jared Bush , Byron Howard', 'Jason Bateman as Nick Wilde • Fortune Feimster as Nibbles', 'comedy', 400, '2h 49m', 0, 'zootopia-2.jpg', '2025-03-14 18:22:44', '2025-11-26'),
(18, 'Accepted', 'After receiving his latest college rejection letter, senior Bartleby Gaines devises a novel way to fool everyone into thinking he is college-bound: Open his own university. Bartleby and his similarly stymied friends take over an abandoned building, create a fake Web site, hire a friend\'s uncle to pose as the dean, and -- presto -- a school is born. However, they do their jobs too well, and soon many other rejects try to gain admittance to the nonexistent South Harmon Institute of Technology.', 'Steve Pink', 'Justin Long • Jonah Hill •Adam Herschman', 'comedy', 650, '1h 3m', 200, 'accepted.jpg', '2025-03-14 18:27:47', '2006-08-18'),
(19, 'Ghostbusters: Frozen Empire', 'The Spengler family returns to the iconic New York City firehouse where the original Ghostbusters have taken ghost-busting to the next level. When the discovery of an ancient artifact unleashes an evil force, Ghostbusters new and old must unite to protect their home and save the world from a second ice age.', 'Gil Kenan', 'Paul Rudd as Gary Grooberson • Carrie Coon as Callie Spengler', 'fantasy', 500, '1h 55m', 542, 'ghostbuster-frozen-empire.jpg', '2025-03-14 18:43:49', '2024-03-22'),
(20, 'King of the Zodiac', 'The \"Knights of the Zodiac\" (2023) film, a live-action adaptation of the anime \"Saint Seiya,\" follows street orphan Seiya who discovers he\'s destined to become a Knight of the Zodiac and protect the reincarnated goddess Athena. ', 'Tomek Baginski', 'Mackenyu as Seiya/Pegasus • Famke Janssen as Vander Guraad', 'fantasy', 800, '1h 52m', 20, 'king-of-the-zodiac.jpg', '2025-03-14 18:43:49', '2023-06-08'),
(21, 'The Golden Compass', 'Lyra Belacqua (Dakota Blue Richards) lives in a parallel world in which human souls take the form of lifelong animal companions called daemons. Dark forces are at work in the girl\'s world, and many children have been kidnapped by beings known as Gobblers. Lyra vows to save her best friend, Roger, after he disappears too. She sets out with her daemon, a tribe of seafarers, a witch, an ice bear and a Texas airman on an epic quest to rescue Roger and save her world.', 'Chris Weitz', 'Dakota Blue Richards • Lyra Belacqua • Nicole Kidman ', 'fantasy', 900, '1h 53m', 3423, 'the-golden-compass.jpg', '2025-03-14 19:03:21', '2007-12-05'),
(22, 'The Huntsman : Winter\'s War', 'Betrayed by her evil sister Ravenna (Charlize Theron), heartbroken Freya (Emily Blunt) retreats to a northern kingdom to raise an army of huntsmen as her protectors. Gifted with the ability to freeze her enemies in ice, Freya teaches her young soldiers to never fall in love. When Eric (Chris Hemsworth) and fellow warrior Sara defy this rule, the angry queen does whatever she can to stop them. As war between the siblings escalates, Eric and Sara try to end Ravenna\'s wicked reign.', 'Cedric Nicolas-Troyan', 'Chris Hemsworth • Charlize Theron • Nick Frost • Sam Claflin ', 'fantasy', 805, '2h', 4353, 'the-huntsman-and-the-ice-queen.jpg', '2025-03-14 19:03:21', '2016-04-22'),
(23, 'The Lord of Rings:The War of the Rohirrim', 'A sudden attack by Wulf, a ruthless Dunlending lord, forces Helm Hammerhand and his people to make a daring last stand in the ancient stronghold of the Hornburg. Finding herself in an increasingly desperate situation, Helm\'s daughter, Héra, must lead the resistance against a deadly enemy who\'s intent on total destruction.', 'Kenji Kamiyama', 'Brian Cox •  Gaia Wise • Miranda Otto • Luca Pasqualino', 'fantasy', 650, '2h 14m', 344, 'the-lord-of-ring-TWOTR.jpg', '2025-03-14 19:03:21', '2024-12-13'),
(26, 'The Northman', 'Prince Amleth is on the verge of becoming a man when his father is brutally murdered by his uncle, who kidnaps the boy\'s mother. Two decades later, Amleth is now a Viking who raids Slavic villages. He soon meets a seeress who reminds him of his vow -- save his mother, kill his uncle, avenge his father.', 'Robert Eggers', 'Alexander Skarsgård • Nicole Kidman • Claes Bang', 'fantasy', 400, '2h 17m', 4564, 'the-northman.jpg', '2025-03-14 19:06:09', '2022-04-22'),
(27, 'Rebel Moon', 'When a colony on the edge of the galaxy finds itself threatened by the armies of the tyrannical Regent Balisarius, they dispatch a young woman with a mysterious past to seek out warriors from neighbouring planets to help them take a stand.', 'Zack Snyder', 'Sofia Boutella as Kora  • Djimon Hounsou as Titus', 'fantasy', 120, '2h 14m', 456, 'rebelmoon.jpg', '2025-03-14 19:11:10', '2023-12-15'),
(28, 'Blue Bettle', 'Jaime Reyes suddenly finds himself in possession of an ancient relic of alien biotechnology called the Scarab. When the Scarab chooses Jaime to be its symbiotic host, he\'s bestowed with an incredible suit of armor that\'s capable of extraordinary and unpredictable powers, forever changing his destiny as he becomes the superhero Blue Beetle.', 'Angel Manuel Soto', 'Xolo Maridueña as Jaime Reyes / Blue Beetle • Adriana Barraza as Nana', 'superheros', 325, '2h 4m', 5676, 'bluebettle.jpg', '2025-03-14 19:35:03', '2023-08-18'),
(29, 'Green Lantern ', 'Sworn to preserve intergalactic order, the Green Lantern Corps has existed for centuries. Its newest recruit, Hal Jordan, is the first human to join the ranks. The Green Lanterns have little regard for humans, who have thus far been unable to harness the powers of the ring each member wears. But Jordan, a gifted and cocky test pilot, may be the corps\' only hope when a new enemy called Parallax threatens the universal balance of power.', 'Martin Campbell', 'Ryan Reynolds as Hal Jordan • Blake Lively as Carol Ferris', 'superheros', 356, '2h 4m', 345, 'greenlantern.jpg', '2025-03-14 19:43:04', '2011-06-16'),
(30, 'Spiderman : Far from Home', 'Peter Parker\'s relaxing European vacation takes an unexpected turn when Nick Fury shows up in his hotel room to recruit him for a mission. The world is in danger as four massive elemental creatures -- each representing Earth, air, water and fire -- emerge from a hole torn in the universe. Parker soon finds himself donning the Spider-Man suit to help Fury and fellow superhero Mysterio stop the evil entities from wreaking havoc across the continent.', 'Jon Watts', '', 'superheros', 600, '1h 41m', 700, 'spiderman-far.jpg', '2025-03-14 19:43:04', '2019-07-02'),
(31, 'Suicide Squad', 'Figuring they\'re all expendable, a U.S. intelligence officer decides to assemble a team of dangerous, incarcerated supervillains for a top-secret mission. Now armed with government weapons, Deadshot (Will Smith), Harley Quinn (Margot Robbie), Captain Boomerang, Killer Croc and other despicable inmates must learn to work together. Dubbed Task Force X, the criminals unite to battle a mysterious and powerful entity, while the diabolical Joker (Jared Leto) launches an evil agenda of his own.', 'David Ayer', '', 'superheros', 900, '1h 53m', 3423, 'Suicideaquad.jpg', '2025-03-14 19:43:04', '2018-04-20'),
(32, 'Shang-Chi and the Legend of the Ten Rings', 'Martial-arts master Shang-Chi confronts the past he thought he left behind when he\'s drawn into the web of the mysterious Ten Rings organization.', 'Destin Daniel Cretton', '', 'superheros', 805, '2h', 4353, 'shang-chi.jpg', '2025-03-14 19:43:04', '2021-09-02'),
(33, 'Venom : The Last Dance', 'Eddie Brock and Venom must make a devastating decision as they\'re pursued by a mysterious military man and alien monsters from Venom\'s home world.', 'Kelly Marcel', '', 'superheros', 650, '2h 14m', 344, 'venom.jpg', '2025-03-14 19:43:04', '2025-10-25'),
(34, 'Kraven the Hunter\r\n', 'Kraven\'s complex relationship with his ruthless father starts him down a path of vengeance, motivating him to become not only the greatest hunter in the world, but also one of its most feared.', 'J.C. Chandor', '', 'superheros', 567, '1h 50m', 12, 'kraven-the-hunter.jpg', '2025-03-14 19:46:21', '2024-12-12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`movie_id`),
  ADD UNIQUE KEY `movie_name` (`movie_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `movie_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
