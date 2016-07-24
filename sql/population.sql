use travelreviews;

insert into users values ('origin', 'origin@gttravel.com', 'root', true);


/* Countries */
insert into country
values ('France', 'origin', 66553766);
insert into country
values ('Spain', 'origin', 48146134);
insert into country
values ('Belgium', 'origin', 11323973);
insert into country
values ('Monaco', 'origin', 37731);
insert into country
values ('Ireland', 'origin', 4892305);

/* ReviewableIDs */
insert into reviewable
values (1);
insert into reviewable
values (2);
insert into reviewable
values (3);
insert into reviewable
values (4);
insert into reviewable
values (5);
insert into reviewable
values (6);
insert into reviewable
values (7);
insert into reviewable
values (8);
insert into reviewable
values (9);
insert into reviewable
values (10);
insert into reviewable
values (11);
insert into reviewable
values (12);
insert into reviewable
values (13);
insert into reviewable
values (14);
insert into reviewable
values (15);
insert into reviewable
values (16);
insert into reviewable
values (17);
insert into reviewable
values (18);
insert into reviewable
values (19);
insert into reviewable
values (20);
insert into reviewable
values (21);
insert into reviewable
values (22);
insert into reviewable
values (23);
insert into reviewable
values (24);
insert into reviewable
values (25);
insert into reviewable
values (26);
insert into reviewable
values (27);
insert into reviewable
values (28);
insert into reviewable
values (29);
insert into reviewable
values (30);
insert into reviewable
values (31);
insert into reviewable
values (32);

/* Cities */
insert into city
values ('Madrid', 'Spain' ,'40 24 N', '3 41 W', 'origin', 1, true, 6489162);
insert into city
values ('Barcelona', 'Spain', '41 23 N', '2 11 E', 'origin', 2, false, 5375774);
insert into city
values ('Valencia', 'Spain', '39 28 N', '0 23 W', 'origin', 3, false, 2516818);
insert into city
values ('Dublin', 'Ireland', '53 20 N',	'6 15 W', 'origin', 4, true, 1801040);
insert into city
values ('Paris', 'France', '48 52 N', '2 20 E', 'origin', 5, true, 12405426);
insert into city
values ('Monaco', 'Monaco', '43 43 N', '7 25 E', 'origin', 6, true,	37731);
insert into city
values ('Brussels', 'Belgium', '50 51 N', '4 21 E', 'origin', 7, true, 1830000);


/* Categories */
insert into categories
values ('Museum');
insert into categories
values ('Stadium');
insert into categories
values ('Restaurant');
insert into categories
values ('Plaza');
insert into categories
values ('Park');
insert into categories
values ('Memorial');
insert into categories
values ('Church');
insert into categories
values ('Concert');
insert into categories
values ('Sports Match');
insert into categories
values ('Race');
insert into categories
values ('Festival');
insert into categories
values ('Presentation');
insert into categories
values ('Other');


/* Locations */
insert into location
values ('101 Disney Way', 'Madrid',	'Spain', 'Retiro Park', 0, 'Park', false, 8);
insert into location
values ('102 Disney Way', 'Madrid',	'Spain', 'The Prado', 15, 'Museum', true, 9);
insert into location
values ('103 Disney Way', 'Madrid', 'Spain', 'Royal Palace', 13, 'Museum', true, 10);
insert into location
values ('104 Disney Way', 'Madrid', 'Spain', 'Opera House', 0, 'Other',	false, 11);
insert into location
values ('105 Disney Way', 'Madrid',	'Spain', 'Reina Sofia', 17, 'Museum', true, 12);
insert into location
values ('106 Disney Way', 'Barcelona', 'Spain', 'Arc d''Triomf', 0, 'Other', false, 13);
insert into location
values ('107 Disney Way', 'Barcelona', 'Spain', 'Camp Nou', 0, 'Stadium', false, 14);
insert into location
values ('108 Disney Way', 'Barcelona', 'Spain', 'Sagrada Familia', 15, 'Church', true, 15);
insert into location
values ('109 Disney Way', 'Barcelona', 'Spain', 'Parc Guell', 8, 'Park', false, 16);
insert into location
values ('110 Disney Way', 'Barcelona', 'Spain', 'Teatre Apolo', 0, 'Other', false, 17);
insert into location
values ('111 Disney Way', 'Paris', 'France', 'Eiffel Tower', 14, 'Other', true, 18);
insert into location
values ('112 Disney Way', 'Paris', 'France', 'Louvre', 25, 'Museum', true, 19);
insert into location
values ('113 Disney Way', 'Paris', 'France', 'Notre Dame', 0, 'Church', false, 20);
insert into location
values ('114 Disney Way', 'Paris', 'France', 'Moulin Rouge', 0, 'Restaurant', false, 21);


/* Events */
insert into event
values ('Beauty and the Beast Sing Along', '2016-04-25', '18:00:00', '106 Disney Way', 'Barcelona', 'Spain', '20:30:00', 15, true, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'Concert', 22);
insert into event
values ('Animating Finding Dory', '2016-08-01', '19:30:00', '109 Disney Way', 'Barcelona', 'Spain', null, 0, false,	'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'Presentation', 23);
insert into event
values ('Brother Bear Live', '2016-05-06', '15:00:00', '110 Disney Way', 'Barcelona', 'Spain', '17:00:00', 20, false, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'Concert', 24);
insert into event
values ('Why Jane Is A Boss', '2016-06-09', '17:30:00', '109 Disney Way', 'Barcelona', 'Spain', null, 5, true, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'Presentation', 25);
insert into event
values ('Beauty and the Beast Sing Along', '2016-07-01', '20:00:00', '106 Disney Way', 'Barcelona', 'Spain', '22:30:00', 15, true, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'Concert', 26);
insert into event
values ('Olaf vs Sven', '2016-07-03', '20:00:00', '107 Disney Way', 'Barcelona', 'Spain', '23:00:00', 30, false, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'Sports Match', 27);
insert into event
values ('Race to Defeat the Huns', '2016-05-09', '12:00:00', '111 Disney Way', 'Paris', 'France', null,	40, false, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'Race', 28);
insert into event
values ('Disney Convention', '2016-01-25', '19:00:00', '112 Disney Way', 'Paris', 'France', '23:00:00', 35, false, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'Festival', 29);
insert into event
values ('Race to See the Floating Lanterns', '2016-03-22', '6:00:00', '111 Disney Way',	'Paris', 'France', '12:00:00', 50, false, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'Race', 30);
insert into event
values ('Brother Bear Live', '2016-06-01', '15:00:00', '114 Disney Way', 'Paris', 'France',	'17:00:00', 20, true, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'Concert', 31); 


/* Languages */
insert into languages
values ('English');
insert into languages
values ('Spanish');
insert into languages
values ('Catalan');
insert into languages
values ('German');
insert into languages
values ('Italian');
insert into languages
values ('French');
insert into languages
values ('Flemish');
insert into languages
values ('Dutch');
insert into languages
values ('Greek');
insert into languages
values ('Valencian');
insert into languages
values ('Galician');
insert into languages
values ('Basque (Euskara)');
insert into languages 
values ('Gaelic');
insert into languages
values ('Portuguese');

/* Country Languages */
insert into countrylanguage
values ('Spain', 'Spanish');
insert into countrylanguage
values ('France', 'French');
insert into countrylanguage
values ('Belgium', 'French');
insert into countrylanguage
values ('Belgium', 'Dutch');
insert into countrylanguage
values ('Belgium', 'German');
insert into countrylanguage
values ('Monaco', 'French');
insert into countrylanguage
values ('Ireland', 'English');
insert into countrylanguage
values ('Ireland', 'Gaelic');

/* City Languages */
insert into citylanguage
values ('Spain', 'Madrid', 'Spanish');
insert into citylanguage
values ('Spain', 'Barcelona', 'Spanish');
insert into citylanguage
values ('Spain', 'Barcelona', 'Catalan');
insert into citylanguage
values ('Spain', 'Valencia', 'Spanish');
insert into citylanguage
values ('Spain', 'Valencia', 'Valencian');
insert into citylanguage
values ('Ireland', 'Dublin', 'English');
insert into citylanguage
values ('Ireland', 'Dublin', 'Gaelic');
insert into citylanguage
values ('France', 'Paris', 'French');
insert into citylanguage
values ('Monaco', 'Monaco', 'French');
insert into citylanguage
values ('Belgium', 'Brussels', 'French');
insert into citylanguage
values ('Belgium', 'Brussels', 'Dutch');



/* Reviews */
insert into review
values ('2016-07-26', 'origin', 5, 'This place was great!a',  20, 'A subject');
insert into review
values ('2016-07-26', 'origin', 3, 'This place was great!b', 3, 'B subject');
insert into review
values ('2016-07-26', 'origin', 5, 'This place was great!c', 19, 'C subject');
insert into review
values ('2016-07-26', 'origin', 5, 'This place was great!d', 4, 'D subject');
insert into review
values ('2016-07-26', 'origin', 1, 'This place was great!e', 22, 'E subject');