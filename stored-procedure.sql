-- (1.1) « I can not access the evaluation before the date and time it has been scheduled for my class. »
-- => raise exception 3001 before insert on test
-- User table should have at least one user
-- Class table needs at least  2 values
-- Class_member will link the user with only one class value
-- create an evaluation for both classes
-- e class, 2 trainers, at least 3 students, 6 row for class_member, 2 evaluation for 1 trainer in a , 2 quiz, 4 or 5 questions by quiz, 1 evaluation for 1st trainer in the 2nd clas  for 2 quiz, 1 evaluation for 1st trainer in the 1nd clas  for 1, 2 quiz; 3 tests for evaluation 1, 3 test for evluation 1 ; 1 with all answers; 1 with 3answers, 1 wtih 2 answers
/* Reset procedure declaration and call, which populate the table */

DELIMITED $
DROP PROCEDURE IF EXISTS init_db $$
CREATE PROCEDURE init_db()
BEGIN
   -- create an user
   INSERT INTO user(user_id,email, pwd, name, first_name)VALUES
   (1, "trainer1@gmail.com", "trainer1", "TRAINER1", "Jean"),
   (2, "trainer2@gmail.com", "trainer2", "TRAINER2", "Marie");
   (3, "student1@gmail.com", "student1", "STUDENT1", "Paul"),
   (4, "student2@gmail.com", "student2", "STUDENT2", "Laura");
   (5, "student3@gmail.com", "student3", "STUDENT3", "Andrew");
  -- Reset table class
  TRUNCATE class;
  -- Create at least 2 classes
  insert into class (class_id, name) values 
   (1, "SQL class for French Student"),
   (2, "SQL class for International Student");
   --- create 1 evaluation per class
   TRUNCATE evaluation
   insert into evaluation (evaluation_id,scheduled_at,ending_at,nb_minutes,class_id);--,trainer_id, quiz_id,completed_at)
   values 
   (1, "14-06-2017", "14-06-2017", 30, 1),
   (1, "14-06-2017", "14-06-2017", 30, 2);
  
    -- register to a class
   INSERT INTO class_member(user_id,class_id)VALUES
   (1, 2);
   
>);
END $$
DELIMITER ;
call init_db();