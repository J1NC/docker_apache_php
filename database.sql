CREATE TABLE User (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(20) NOT NULL,
    nickname VARCHAR(30) NOT NULL,
    password VARCHAR(50) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    gender VARCHAR(10),
    recommendCode VARCHAR(20) UNIQUE NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE Recommend (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    recommender INT(11),
    recommendee INT(11),
    FOREIGN KEY (recommender) REFERENCES User(id) ON DELETE CASCADE,
    FOREIGN KEY (recommendee) REFERENCES User(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO User(name, nickname, password, phone, email, gender, recommendCode)
            VALUES
            ('테스트','test','1234','01000000000', 'test1@gmail.com', 'male', '5dce28d495361'),
            ('테스트','test','1234','01000000000', 'test2@gmail.com', 'male', '5dce2d1391f6f'),
            ('테스트','test','1234','01000000000', 'test3@gmail.com', 'male', '5dce2d1715631'),
            ('테스트','test','1234','01000000000', 'test4@gmail.com', 'male', '5dce2d1ddb254'),
            ('테스트','test','1234','01000000000', 'test5@gmail.com', 'male', '5dce2d211d216'),
            ('테스트','test','1234','01000000000', 'test6@gmail.com', 'male', '5dce2d1ae859e'),
            ('테스트','test','1234','01000000000', 'test7@gmail.com', 'male', '5dce2d253fb15'),
            ('테스트','test','1234','01000000000', 'test8@gmail.com', 'male', '5dce2d2adfd67'),
            ('테스트','test','1234','01000000000', 'test9@gmail.com', 'male', '5dce28d49s261'),
            ('테스트','test','1234','01000000000', 'test10@gmail.com', 'male', '5dce28d4fd41');

INSERT INTO Recommend(recommender, recommendee)
            VALUES
            (1,2),
            (1,3),
            (1,4),
            (1,5),
            (2,6),
            (2,7),
            (2,8),
            (2,9),
            (2,10);
