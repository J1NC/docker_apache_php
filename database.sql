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
    recommender INT(11) NOT NULL,
    recommendee INT(11) NOT NULL,
    PRIMARY KEY(recommender, recommendee),
    FOREIGN KEY (recommender) REFERENCES User(id),
    FOREIGN KEY (recommendee) REFERENCES User(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;