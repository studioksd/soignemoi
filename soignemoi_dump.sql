--
-- PostgreSQL database dump
--

-- Dumped from database version 12.17 (Ubuntu 12.17-0ubuntu0.20.04.1)
-- Dumped by pg_dump version 12.17 (Ubuntu 12.17-0ubuntu0.20.04.1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: avis_medecin; Type: TABLE; Schema: public; Owner: ubuntu
--

CREATE TABLE public.avis_medecin (
    id integer NOT NULL,
    medecin_id integer,
    patient_id integer NOT NULL,
    libelle character varying(255) DEFAULT NULL::character varying,
    date date,
    description character varying(255) DEFAULT NULL::character varying
);


ALTER TABLE public.avis_medecin OWNER TO ubuntu;

--
-- Name: avis_medecin_id_seq; Type: SEQUENCE; Schema: public; Owner: ubuntu
--

CREATE SEQUENCE public.avis_medecin_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.avis_medecin_id_seq OWNER TO ubuntu;

--
-- Name: medecin; Type: TABLE; Schema: public; Owner: ubuntu
--

CREATE TABLE public.medecin (
    id integer NOT NULL,
    nom character varying(255) NOT NULL,
    prenom character varying(255) NOT NULL,
    specialite character varying(255) NOT NULL,
    matricule character varying(255) NOT NULL
);


ALTER TABLE public.medecin OWNER TO ubuntu;

--
-- Name: medecin_id_seq; Type: SEQUENCE; Schema: public; Owner: ubuntu
--

CREATE SEQUENCE public.medecin_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.medecin_id_seq OWNER TO ubuntu;

--
-- Name: medicament_id_seq; Type: SEQUENCE; Schema: public; Owner: ubuntu
--

CREATE SEQUENCE public.medicament_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.medicament_id_seq OWNER TO ubuntu;

--
-- Name: prescription; Type: TABLE; Schema: public; Owner: ubuntu
--

CREATE TABLE public.prescription (
    id integer NOT NULL,
    medecin_id integer,
    patient_id integer NOT NULL,
    avis_medecin_id integer,
    date_debut date NOT NULL,
    date_fin date NOT NULL,
    medicaments json
);


ALTER TABLE public.prescription OWNER TO ubuntu;

--
-- Name: prescription_id_seq; Type: SEQUENCE; Schema: public; Owner: ubuntu
--

CREATE SEQUENCE public.prescription_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.prescription_id_seq OWNER TO ubuntu;

--
-- Name: sejour; Type: TABLE; Schema: public; Owner: ubuntu
--

CREATE TABLE public.sejour (
    id integer NOT NULL,
    medecin_id integer,
    utilisateur_id integer,
    date_debut date NOT NULL,
    date_fin date NOT NULL,
    motif character varying(255) DEFAULT NULL::character varying,
    specialite_necessaire character varying(255) DEFAULT NULL::character varying
);


ALTER TABLE public.sejour OWNER TO ubuntu;

--
-- Name: sejour_id_seq; Type: SEQUENCE; Schema: public; Owner: ubuntu
--

CREATE SEQUENCE public.sejour_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sejour_id_seq OWNER TO ubuntu;

--
-- Name: utilisateur; Type: TABLE; Schema: public; Owner: ubuntu
--

CREATE TABLE public.utilisateur (
    id integer NOT NULL,
    email character varying(180) NOT NULL,
    roles json NOT NULL,
    password character varying(255) NOT NULL,
    nom character varying(255) DEFAULT NULL::character varying,
    prenom character varying(255) DEFAULT NULL::character varying,
    adresse character varying(255) DEFAULT NULL::character varying
);


ALTER TABLE public.utilisateur OWNER TO ubuntu;

--
-- Name: utilisateur_id_seq; Type: SEQUENCE; Schema: public; Owner: ubuntu
--

CREATE SEQUENCE public.utilisateur_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.utilisateur_id_seq OWNER TO ubuntu;

--
-- Data for Name: avis_medecin; Type: TABLE DATA; Schema: public; Owner: ubuntu
--

COPY public.avis_medecin (id, medecin_id, patient_id, libelle, date, description) FROM stdin;
3	12	17	Avis de M. PATIENT	2024-02-29	Il devrait se rétablir vite.
4	11	15	Avis de M. PATIENT Deuxième	2024-03-20	Bien continuer à suivre le traitement
\.


--
-- Data for Name: medecin; Type: TABLE DATA; Schema: public; Owner: ubuntu
--

COPY public.medecin (id, nom, prenom, specialite, matricule) FROM stdin;
5	Klimt	Gustav	Cardiologie	325PL
6	Baker	Annie	Gynécologie	453US
7	Debbache	Karim	Cardiologie	266FR
8	Nivel	Jérôme	Pédiatrie	148FR
9	Narrate	Marshall	Orthopédie	619US
10	Sczykof	Thomas	Neurologie	976CZ
11	Chalot	Martin	Dermatologie	457ZR
12	Fayard	Lucas	Ophtalmologie	902KC
13	Spedowa	Veronika	Neurologie	989RU
\.


--
-- Data for Name: prescription; Type: TABLE DATA; Schema: public; Owner: ubuntu
--

COPY public.prescription (id, medecin_id, patient_id, avis_medecin_id, date_debut, date_fin, medicaments) FROM stdin;
10	12	17	3	2024-02-20	2024-02-29	[{"libelle":"Doliprane","posologie":"3\\/j"},{"libelle":"Smecta","posologie":"2 max.\\/j"}]
11	11	15	\N	2024-03-05	2024-02-20	[{"libelle":"Antilepro","posologie":"1 \\u00e0 chaque repas"},{"libelle":"Lexamini","posologie":"1\\/jour maximum, avant de dormir"}]
12	11	15	4	2024-03-05	2024-02-20	[]
\.


--
-- Data for Name: sejour; Type: TABLE DATA; Schema: public; Owner: ubuntu
--

COPY public.sejour (id, medecin_id, utilisateur_id, date_debut, date_fin, motif, specialite_necessaire) FROM stdin;
7	12	17	2024-02-25	2024-02-29	Opération LASIK	Ophtalmologie
8	11	15	2024-03-05	2024-03-20	Traitement contre la lèpre	Dermatologie
9	10	14	2024-02-22	2024-02-27	Greffe du cerveau	Neurologie
10	7	16	2024-04-01	2024-02-16	Opération pacemaker	Cardiologie
\.


--
-- Data for Name: utilisateur; Type: TABLE DATA; Schema: public; Owner: ubuntu
--

COPY public.utilisateur (id, email, roles, password, nom, prenom, adresse) FROM stdin;
11	admin@soignemoi.fr	["ROLE_ADMIN"]	$2y$13$4dGsCFH5gsYuGaNGXtr27uFlw5dwxDCfWshUm.sSBa8hLePPU3tbq	ADMIN	Admin	1 rue de l'Admin
12	medecin@soignemoi.fr	["ROLE_MEDECIN"]	$2y$13$0HmorU8Hcpugykr9KIo/gO2OlwWBWKG.O6ppEL6yPzwJe9di3NS9K	MEDECIN	Medecin	2 rue de la Médecine
13	secretaire@soignemoi.fr	["ROLE_SECRETAIRE"]	$2y$13$0v8oWYEv1wVFHOrEslCkZOxtBM55GKuqN4sNPXbJUcwoqMVj./.3u	SECRETAIRE	Secrétaire	3 rue du Secrétariat
14	patient1@soignemoi.fr	["ROLE_VISITEUR"]	$2y$13$PVC3dA/R2x7TKZdXVheoI.Zi8LrOD9M8Sd4YeysFLaMjwLt1z26R2	PATIENT	Patient	8 rue Patiente
15	patient2@soignemoi.fr	["ROLE_VISITEUR"]	$2y$13$irns4W08iW9LTQePLY6wg.C0fbDfFajMuKL7C/0odDdiiOxcuuJdu	PATIENT	Deuxième	9 rue Patiente
16	patient3@soignemoi.fr	["ROLE_VISITEUR"]	$2y$13$2y1nX29wwrTXeY6iTiCG2uTbiOMHfZRH44sCtuy.6rN3sUVQIWDae	PATIENT	Troisième	10 rue Patiente
17	patient4@soignemoi.fr	["ROLE_VISITEUR"]	$2y$13$iHLkTRzantT0tx6YzRxPa.sZ8RdLAQcqyTtKWElGZJxYQ/flMo9Vy	PATIENT	Quatrième	11 rue Patiente
\.


--
-- Name: avis_medecin_id_seq; Type: SEQUENCE SET; Schema: public; Owner: ubuntu
--

SELECT pg_catalog.setval('public.avis_medecin_id_seq', 4, true);


--
-- Name: medecin_id_seq; Type: SEQUENCE SET; Schema: public; Owner: ubuntu
--

SELECT pg_catalog.setval('public.medecin_id_seq', 13, true);


--
-- Name: medicament_id_seq; Type: SEQUENCE SET; Schema: public; Owner: ubuntu
--

SELECT pg_catalog.setval('public.medicament_id_seq', 1, false);


--
-- Name: prescription_id_seq; Type: SEQUENCE SET; Schema: public; Owner: ubuntu
--

SELECT pg_catalog.setval('public.prescription_id_seq', 12, true);


--
-- Name: sejour_id_seq; Type: SEQUENCE SET; Schema: public; Owner: ubuntu
--

SELECT pg_catalog.setval('public.sejour_id_seq', 10, true);


--
-- Name: utilisateur_id_seq; Type: SEQUENCE SET; Schema: public; Owner: ubuntu
--

SELECT pg_catalog.setval('public.utilisateur_id_seq', 17, true);


--
-- Name: avis_medecin avis_medecin_pkey; Type: CONSTRAINT; Schema: public; Owner: ubuntu
--

ALTER TABLE ONLY public.avis_medecin
    ADD CONSTRAINT avis_medecin_pkey PRIMARY KEY (id);


--
-- Name: medecin medecin_pkey; Type: CONSTRAINT; Schema: public; Owner: ubuntu
--

ALTER TABLE ONLY public.medecin
    ADD CONSTRAINT medecin_pkey PRIMARY KEY (id);


--
-- Name: prescription prescription_pkey; Type: CONSTRAINT; Schema: public; Owner: ubuntu
--

ALTER TABLE ONLY public.prescription
    ADD CONSTRAINT prescription_pkey PRIMARY KEY (id);


--
-- Name: sejour sejour_pkey; Type: CONSTRAINT; Schema: public; Owner: ubuntu
--

ALTER TABLE ONLY public.sejour
    ADD CONSTRAINT sejour_pkey PRIMARY KEY (id);


--
-- Name: utilisateur utilisateur_pkey; Type: CONSTRAINT; Schema: public; Owner: ubuntu
--

ALTER TABLE ONLY public.utilisateur
    ADD CONSTRAINT utilisateur_pkey PRIMARY KEY (id);


--
-- Name: idx_1fbfb8d94f31a84; Type: INDEX; Schema: public; Owner: ubuntu
--

CREATE INDEX idx_1fbfb8d94f31a84 ON public.prescription USING btree (medecin_id);


--
-- Name: idx_1fbfb8d96b899279; Type: INDEX; Schema: public; Owner: ubuntu
--

CREATE INDEX idx_1fbfb8d96b899279 ON public.prescription USING btree (patient_id);


--
-- Name: idx_30d9c3c04f31a84; Type: INDEX; Schema: public; Owner: ubuntu
--

CREATE INDEX idx_30d9c3c04f31a84 ON public.avis_medecin USING btree (medecin_id);


--
-- Name: idx_30d9c3c06b899279; Type: INDEX; Schema: public; Owner: ubuntu
--

CREATE INDEX idx_30d9c3c06b899279 ON public.avis_medecin USING btree (patient_id);


--
-- Name: idx_96f520284f31a84; Type: INDEX; Schema: public; Owner: ubuntu
--

CREATE INDEX idx_96f520284f31a84 ON public.sejour USING btree (medecin_id);


--
-- Name: idx_96f52028fb88e14f; Type: INDEX; Schema: public; Owner: ubuntu
--

CREATE INDEX idx_96f52028fb88e14f ON public.sejour USING btree (utilisateur_id);


--
-- Name: uniq_1d1c63b3e7927c74; Type: INDEX; Schema: public; Owner: ubuntu
--

CREATE UNIQUE INDEX uniq_1d1c63b3e7927c74 ON public.utilisateur USING btree (email);


--
-- Name: uniq_1fbfb8d9e836bdbd; Type: INDEX; Schema: public; Owner: ubuntu
--

CREATE UNIQUE INDEX uniq_1fbfb8d9e836bdbd ON public.prescription USING btree (avis_medecin_id);


--
-- Name: prescription fk_1fbfb8d94f31a84; Type: FK CONSTRAINT; Schema: public; Owner: ubuntu
--

ALTER TABLE ONLY public.prescription
    ADD CONSTRAINT fk_1fbfb8d94f31a84 FOREIGN KEY (medecin_id) REFERENCES public.medecin(id);


--
-- Name: prescription fk_1fbfb8d96b899279; Type: FK CONSTRAINT; Schema: public; Owner: ubuntu
--

ALTER TABLE ONLY public.prescription
    ADD CONSTRAINT fk_1fbfb8d96b899279 FOREIGN KEY (patient_id) REFERENCES public.utilisateur(id);


--
-- Name: prescription fk_1fbfb8d9e836bdbd; Type: FK CONSTRAINT; Schema: public; Owner: ubuntu
--

ALTER TABLE ONLY public.prescription
    ADD CONSTRAINT fk_1fbfb8d9e836bdbd FOREIGN KEY (avis_medecin_id) REFERENCES public.avis_medecin(id);


--
-- Name: avis_medecin fk_30d9c3c04f31a84; Type: FK CONSTRAINT; Schema: public; Owner: ubuntu
--

ALTER TABLE ONLY public.avis_medecin
    ADD CONSTRAINT fk_30d9c3c04f31a84 FOREIGN KEY (medecin_id) REFERENCES public.medecin(id);


--
-- Name: avis_medecin fk_30d9c3c06b899279; Type: FK CONSTRAINT; Schema: public; Owner: ubuntu
--

ALTER TABLE ONLY public.avis_medecin
    ADD CONSTRAINT fk_30d9c3c06b899279 FOREIGN KEY (patient_id) REFERENCES public.utilisateur(id);


--
-- Name: sejour fk_96f520284f31a84; Type: FK CONSTRAINT; Schema: public; Owner: ubuntu
--

ALTER TABLE ONLY public.sejour
    ADD CONSTRAINT fk_96f520284f31a84 FOREIGN KEY (medecin_id) REFERENCES public.medecin(id);


--
-- Name: sejour fk_96f52028fb88e14f; Type: FK CONSTRAINT; Schema: public; Owner: ubuntu
--

ALTER TABLE ONLY public.sejour
    ADD CONSTRAINT fk_96f52028fb88e14f FOREIGN KEY (utilisateur_id) REFERENCES public.utilisateur(id);


--
-- PostgreSQL database dump complete
--

