CREATE TABLE IF NOT EXISTS "migrations"(
  "id" integer primary key autoincrement not null,
  "migration" varchar not null,
  "batch" integer not null
);
CREATE TABLE IF NOT EXISTS "users"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "email" varchar not null,
  "email_verified_at" datetime,
  "password" varchar not null,
  "remember_token" varchar,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE UNIQUE INDEX "users_email_unique" on "users"("email");
CREATE TABLE IF NOT EXISTS "password_reset_tokens"(
  "email" varchar not null,
  "token" varchar not null,
  "created_at" datetime,
  primary key("email")
);
CREATE TABLE IF NOT EXISTS "sessions"(
  "id" varchar not null,
  "user_id" integer,
  "ip_address" varchar,
  "user_agent" text,
  "payload" text not null,
  "last_activity" integer not null,
  primary key("id")
);
CREATE INDEX "sessions_user_id_index" on "sessions"("user_id");
CREATE INDEX "sessions_last_activity_index" on "sessions"("last_activity");
CREATE TABLE IF NOT EXISTS "cache"(
  "key" varchar not null,
  "value" text not null,
  "expiration" integer not null,
  primary key("key")
);
CREATE TABLE IF NOT EXISTS "cache_locks"(
  "key" varchar not null,
  "owner" varchar not null,
  "expiration" integer not null,
  primary key("key")
);
CREATE TABLE IF NOT EXISTS "jobs"(
  "id" integer primary key autoincrement not null,
  "queue" varchar not null,
  "payload" text not null,
  "attempts" integer not null,
  "reserved_at" integer,
  "available_at" integer not null,
  "created_at" integer not null
);
CREATE INDEX "jobs_queue_index" on "jobs"("queue");
CREATE TABLE IF NOT EXISTS "job_batches"(
  "id" varchar not null,
  "name" varchar not null,
  "total_jobs" integer not null,
  "pending_jobs" integer not null,
  "failed_jobs" integer not null,
  "failed_job_ids" text not null,
  "options" text,
  "cancelled_at" integer,
  "created_at" integer not null,
  "finished_at" integer,
  primary key("id")
);
CREATE TABLE IF NOT EXISTS "failed_jobs"(
  "id" integer primary key autoincrement not null,
  "uuid" varchar not null,
  "connection" text not null,
  "queue" text not null,
  "payload" text not null,
  "exception" text not null,
  "failed_at" datetime not null default CURRENT_TIMESTAMP
);
CREATE UNIQUE INDEX "failed_jobs_uuid_unique" on "failed_jobs"("uuid");
CREATE TABLE IF NOT EXISTS "profiles"(
  "id" integer primary key autoincrement not null,
  "user_id" integer not null,
  "user_type" varchar check("user_type" in('medico', 'hospital')) not null,
  "crm" varchar,
  "specialty" varchar,
  "hospital_name" varchar,
  "cnpj" varchar,
  "address" varchar,
  "phone_number" varchar,
  "created_at" datetime,
  "updated_at" datetime,
  "data_nascimento" date,
  "cpf" varchar,
  "rg" varchar,
  "estado_civil" varchar,
  "nacionalidade" varchar,
  "endereco_completo" text,
  "telefone_celular" varchar,
  foreign key("user_id") references "users"("id") on delete cascade
);
CREATE UNIQUE INDEX "profiles_crm_unique" on "profiles"("crm");
CREATE UNIQUE INDEX "profiles_cnpj_unique" on "profiles"("cnpj");
CREATE TABLE IF NOT EXISTS "plantao_profile"(
  "id" integer primary key autoincrement not null,
  "plantao_id" integer not null,
  "profile_id" integer not null,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("plantao_id") references "plantoes"("id") on delete cascade,
  foreign key("profile_id") references "profiles"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "plantoes"(
  "id" integer primary key autoincrement not null,
  "profile_id" integer not null,
  "specialty" varchar not null,
  "date" date not null,
  "start_time" time not null,
  "end_time" time not null,
  "remuneration" numeric not null,
  "details" text,
  "status" varchar not null default('disponivel'),
  "created_at" datetime,
  "updated_at" datetime,
  "approved_profile_id" integer,
  foreign key("profile_id") references profiles("id") on delete cascade on update no action,
  foreign key("approved_profile_id") references "profiles"("id") on delete set null
);
CREATE TABLE IF NOT EXISTS "notifications"(
  "id" varchar not null,
  "type" varchar not null,
  "notifiable_type" varchar not null,
  "notifiable_id" integer not null,
  "data" text not null,
  "read_at" datetime,
  "created_at" datetime,
  "updated_at" datetime,
  primary key("id")
);
CREATE INDEX "notifications_notifiable_type_notifiable_id_index" on "notifications"(
  "notifiable_type",
  "notifiable_id"
);
CREATE UNIQUE INDEX "profiles_cpf_unique" on "profiles"("cpf");
CREATE TABLE IF NOT EXISTS "documentos"(
  "id" integer primary key autoincrement not null,
  "profile_id" integer not null,
  "tipo_documento" varchar not null,
  "caminho_arquivo" varchar not null,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("profile_id") references "profiles"("id") on delete cascade
);

INSERT INTO migrations VALUES(1,'0001_01_01_000000_create_users_table',1);
INSERT INTO migrations VALUES(2,'0001_01_01_000001_create_cache_table',1);
INSERT INTO migrations VALUES(3,'0001_01_01_000002_create_jobs_table',1);
INSERT INTO migrations VALUES(4,'2025_10_01_132812_create_profiles_table',1);
INSERT INTO migrations VALUES(5,'2025_10_01_172134_create_plantaos_table',1);
INSERT INTO migrations VALUES(6,'2025_10_01_184859_create_plantao_profile_table',1);
INSERT INTO migrations VALUES(7,'2025_10_01_193241_add_approved_profile_id_to_plantoes_table',1);
INSERT INTO migrations VALUES(8,'2025_10_02_124226_create_notifications_table',1);
INSERT INTO migrations VALUES(9,'2025_10_02_173030_add_personal_fields_to_profiles_table',1);
INSERT INTO migrations VALUES(10,'2025_10_02_175143_create_documentos_table',1);
INSERT INTO migrations VALUES(11,'2025_10_03_132312_add_caminho_foto_perfil_to_profiles_table',1);
INSERT INTO migrations VALUES(12,'2025_10_03_134233_add_status_to_documentos_table',1);
