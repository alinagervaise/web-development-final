-- (1.1) « I can not access the evaluation before the date and time it has been scheduled for my class. »
-- => raise exception 3001 before insert on test
-- User table should have at least one user
-- Class table needs at least  2 values
-- Class_member will link the user with only one class value
-- create an evaluation for both classes
/* Reset procedure declaration and call, which populate the table */

DELIMITED $
DROP PROCEDURE IF EXISTS init_db $$
CREATE PROCEDURE init_db()
BEGIN
  -- Reset table class
  TRUNCATE class;
  -- Create at least 2 classes
  insert into class (class_id, name) values 
   (1, "SQL class for French Student"),
   (2, "SQL class for International Student");

   insert into evaluation (evaluation_id,scheduled_at,ending_at,nb_minutes,class_id);--,trainer_id, quiz_id,completed_at)
   values (1, "14-06-2017", "14-06-2017", 30, 1);
   values (1, "14-06-2017", "14-06-2017", 30, 2);
END $$
DELIMITER ;
call init_db();