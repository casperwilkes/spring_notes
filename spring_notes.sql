-- Create db
CREATE DATABASE IF NOT EXISTS `s_notes` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

-- Create user
CREATE USER 'spring'@'localhost' IDENTIFIED BY  'pastword';

-- Assign database
GRANT SELECT, INSERT, UPDATE, DELETE ON  `s\_notes` . * TO  'spring'@'localhost';

-- Flush the privledges so we can use new user
FLUSH PRIVILEGES;

-- Switch to table
USE `s_notes`;

-- Create users table
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(64) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Create Notes table
CREATE TABLE IF NOT EXISTS `notes` (
  `id` bigint(64) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(64) NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Create users --
INSERT INTO `users` (`id`, `name`, `email`, `password`, `updated_at`, `created_at`) VALUES
(1, 'test', 'test@test.com', '$2y$10$Q7hi.IQlFFY3A96BJveDtOPQ9Nf40i2Vf4QV0g8IoDYA8RZtgTD06', NULL, '2017-11-08 22:46:29'),
(2, 'marsha brady', 'marsha@brady.com', '$2y$10$.x477pM63JZHYoPWZpzsh.PJI3T8hevy7rQDOi44Z9Ly73WxxKhKm', NULL, '2017-11-08 22:47:26'),
(3, 'casper wilkes', 'casper@casperwilkes.net', '$2y$10$3FrLwBQKAEFoiz5/OEYMSeyeJLT69tUWi9MVOc9ykUOS0mIHytpAC', NULL, '2017-11-08 22:47:56'),
(4, 'bobby drop tables', 'bobby@tables.com', '$2y$10$DnH5dw4NUtcA7jIp/jwVFOXyQizB7d.stwTwMT3JbdbbekBmMq1LG', NULL, '2017-11-08 22:48:56');

-- Create notes --
INSERT INTO `notes` (`id`, `user_id`, `title`, `body`, `created_at`, `updated_at`) VALUES
(1, 1, 'A Simple Sample', 'Here is a sample note', '2017-11-08 22:50:06', NULL),
(2, 1, 'Another Simple Sample', 'Here is another simple sample.\r\n\r\nThis is a modified note.', '2017-11-08 22:50:54', '2017-11-08 22:51:12'),
(3, 1, 'Lorum Ipsum', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.\r\n\r\nDuis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.', '2017-11-08 22:52:03', NULL),
(4, 2, 'The Wolf & the Crane', 'A Wolf had been feasting too greedily, and a bone had stuck crosswise in his throat. He could get it neither up nor down, and of course he could not eat a thing. Naturally that was an awful state of affairs for a greedy Wolf.\r\nSo away he hurried to the Crane. He was sure that she, with her long neck and bill, would easily be able to reach the bone and pull it out.\r\n"I will reward you very handsomely," said the Wolf, "if you pull that bone out for me."\r\nThe Crane, as you can imagine, was very uneasy about putting her head in a Wolf''s throat. But she was grasping in nature, so she did what the Wolf asked her to do.\r\nWhen the Wolf felt that the bone was gone, he started to walk away.\r\n"But what about my reward!" called the Crane anxiously.\r\n"What!" snarled the Wolf, whirling around. "Haven''t you got it? Isn''t it enough that I let you take your head out of my mouth without snapping it off?"\r\nExpect no reward for serving the wicked.', '2017-11-08 22:52:43', NULL),
(5, 2, 'The Oak & the Reeds', 'A Giant Oak stood near a brook in which grew some slender Reeds. When the wind blew, the great Oak stood proudly upright with its hundred arms uplifted to the sky. But the Reeds bowed low in the wind and sang a sad and mournful song.\r\n"You have reason to complain," said the Oak. "The slightest breeze that ruffles the surface of the water makes you bow your heads, while I, the mighty Oak, stand upright and firm before the howling tempest."\r\n"Do not worry about us," replied the Reeds. "The winds do not harm us. We bow before them and so we do not break. You, in all your pride and strength, have so far resisted their blows. But the end is coming."\r\nAs the Reeds spoke a great hurricane rushed out of the north. The Oak stood proudly and fought against the storm, while the yielding Reeds bowed low. The wind redoubled in fury, and all at once the great tree fell, torn up by the roots, and lay among the pitying Reeds.\r\nBetter to yield when it is folly to resist, than to resist stubbornly and be destroyed.', '2017-11-08 22:53:00', NULL),
(6, 2, 'The Gnat & the Bull', 'A Gnat flew over the meadow with much buzzing for so small a creature and settled on the tip of one of the horns of a Bull. After he had rested a short time, he made ready to fly away. But before he left he begged the Bull''s pardon for having used his horn for a resting place.\r\n"You must be very glad to have me go now," he said.\r\n"It''s all the same to me," replied the Bull. "I did not even know you were there."\r\nWe are often of greater importance in our own eyes than in the eyes of our neighbor. The smaller the mind the greater the conceit.', '2017-11-08 22:53:38', NULL),
(7, 3, 'lingo', 'Phosfluorescently benchmark fully tested information before ubiquitous web services. Enthusiastically deploy synergistic services vis-a-vis bleeding-edge bandwidth. Professionally initiate integrated expertise with principle-centered infomediaries. Appropriately syndicate fully researched web services after backward-compatible supply chains. Appropriately provide access to highly efficient benefits rather than prospective models.\r\n', '2017-11-08 22:54:06', NULL),
(8, 3, 'lot''s o lingo', 'Globally customize dynamic strategic theme areas whereas one-to-one supply chains. Monotonectally incubate sticky deliverables whereas enterprise-wide value. Holisticly underwhelm cutting-edge mindshare after interactive processes. Competently predominate business information whereas process-centric e-services. Proactively synergize intuitive resources after frictionless deliverables.\r\n\r\nObjectively disintermediate market positioning web-readiness before covalent intellectual capital. Collaboratively disintermediate maintainable mindshare after principle-centered models. Objectively strategize resource sucking schemas whereas collaborative core competencies. Uniquely brand parallel e-business with go forward process improvements. Conveniently scale quality products vis-a-vis equity invested solutions.\r\n\r\nSynergistically actualize compelling services whereas high-quality alignments. Intrinsicly provide access to accurate content without adaptive "outside the box" thinking. Phosfluorescently seize robust information without an expanded array of scenarios. Holisticly maintain stand-alone strategic theme areas after cost effective supply chains. Quickly implement sustainable communities through clicks-and-mortar convergence.', '2017-11-08 22:54:33', NULL),
(9, 3, 'modified lingo', 'Credibly redefine B2B web-readiness for clicks-and-mortar methods of empowerment. Credibly scale transparent web-readiness after 2.0 alignments. Dynamically leverage other''s top-line catalysts for change without customized platforms. Dramatically pursue error-free quality vectors with value-added relationships. Proactively exploit dynamic paradigms and bleeding-edge benefits.\r\n\r\nDynamically transition go forward bandwidth via client-centric benefits. Rapidiously incubate process-centric functionalities without global communities. Energistically facilitate e-business initiatives whereas ethical ideas. Assertively architect orthogonal experiences via orthogonal models. Globally deploy vertical experiences after market positioning sources.\r\n\r\nDramatically underwhelm accurate human capital with innovative leadership skills. Energistically aggregate vertical architectures with corporate synergy. Phosfluorescently formulate wireless process improvements rather than enterprise initiatives. Distinctively negotiate state of the art testing procedures and progressive process improvements. Holisticly empower real-time human capital via collaborative innovation.\r\n\r\nCredibly create enterprise web-readiness through effective web services. Uniquely envisioneer collaborative metrics for user friendly e-services. Appropriately synthesize sustainable data via interoperable deliverables. Credibly pontificate exceptional users and accurate platforms. Competently create end-to-end infomediaries whereas client-based solutions.', '2017-11-08 22:54:49', '2017-11-08 22:55:08');
