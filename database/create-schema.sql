
CREATE TABLE TASK (
  TASK_ID     VARCHAR(255) NOT NULL,
  USER_ID     VARCHAR(255) NOT NULL,
  TIMESTAMP   TIMESTAMP NOT NULL,
  TITLE       VARCHAR(255) NOT NULL,
  DESCRIPTION VARCHAR(255),
  DONE        BOOLEAN,
  PRIMARY KEY (TASK_ID)
);
