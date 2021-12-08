DROP TABLE IF EXISTS "main_table";
DROP SEQUENCE IF EXISTS main_table_id_seq;
CREATE SEQUENCE main_table_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."main_table" (
    "id" integer DEFAULT nextval('main_table_id_seq') NOT NULL,
    "long_link" text NOT NULL,
    "short_link" text NOT NULL,
    "views" integer,
    "user_id" integer NOT NULL,
    CONSTRAINT "main_table_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "main_table" ("id", "long_link", "short_link", "views", "user_id") VALUES
(1,	'http://yandex.ru',	'ya',	0,	1);

DROP TABLE IF EXISTS "users_table";
DROP SEQUENCE IF EXISTS users_table_id_seq;
CREATE SEQUENCE users_table_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."users_table" (
    "id" integer DEFAULT nextval('users_table_id_seq') NOT NULL,
    "login" text NOT NULL,
    "pass" text NOT NULL,
    CONSTRAINT "users_table_id" PRIMARY KEY ("id"),
    CONSTRAINT "users_table_login" UNIQUE ("login")
) WITH (oids = false);

