--
-- PostgreSQL database dump
--

-- Dumped from database version 12.6 (Debian 12.6-1.pgdg100+1)
-- Dumped by pg_dump version 12.6 (Debian 12.6-1.pgdg100+1)

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

--
-- Name: categoria_enum; Type: TYPE; Schema: public; Owner: postgres
--

CREATE TYPE public.categoria_enum AS ENUM (
    'Renda Fixa',
    'Renda Variável'
);


ALTER TYPE public.categoria_enum OWNER TO postgres;

--
-- Name: tipo_enum; Type: TYPE; Schema: public; Owner: postgres
--

CREATE TYPE public.tipo_enum AS ENUM (
    'Tesouro Direto',
    'Fundos de Investimentos',
    'CDB',
    'Debêntures',
    'Ações',
    'Criptomoeda',
    'Dollar',
    'Ouro',
    'Prata',
    'ETFs',
    'FIIs'
);


ALTER TYPE public.tipo_enum OWNER TO postgres;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: acao_bolsa; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.acao_bolsa (
    id integer NOT NULL,
    nome text NOT NULL,
    codigo character varying(5) NOT NULL,
    setor text NOT NULL,
    cnpj text NOT NULL,
    tag_along_on smallint,
    free_float smallint,
    governo boolean,
    rank_ano real,
    rank_trimestre real,
    data_atualizacao_rank timestamp without time zone,
    habilita_rank boolean DEFAULT true
);


ALTER TABLE public.acao_bolsa OWNER TO postgres;

--
-- Name: acao_bolsa_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.acao_bolsa_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.acao_bolsa_id_seq OWNER TO postgres;

--
-- Name: acao_bolsa_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.acao_bolsa_id_seq OWNED BY public.acao_bolsa.id;


--
-- Name: ativo; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.ativo (
    id integer NOT NULL,
    nome text NOT NULL,
    codigo text NOT NULL,
    acao_bolsa_id integer,
    categoria public.categoria_enum,
    tipo public.tipo_enum,
    pais character varying(2) DEFAULT 'BR'::character varying NOT NULL,
    classe_atualiza_id integer
);


ALTER TABLE public.ativo OWNER TO postgres;

--
-- Name: ativo_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.ativo_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.ativo_id_seq OWNER TO postgres;

--
-- Name: ativo_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.ativo_id_seq OWNED BY public.ativo.id;


--
-- Name: atualiza_acoes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.atualiza_acoes (
    id integer NOT NULL,
    data timestamp without time zone NOT NULL,
    ativo_atualizado jsonb,
    status text NOT NULL
);


ALTER TABLE public.atualiza_acoes OWNER TO postgres;

--
-- Name: atualiza_acoes_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.atualiza_acoes_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.atualiza_acoes_id_seq OWNER TO postgres;

--
-- Name: atualiza_acoes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.atualiza_acoes_id_seq OWNED BY public.atualiza_acoes.id;


--
-- Name: atualiza_ativo_manual; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.atualiza_ativo_manual (
    id integer NOT NULL,
    itens_ativo_id integer NOT NULL
);


ALTER TABLE public.atualiza_ativo_manual OWNER TO postgres;

--
-- Name: atualiza_ativo_manual_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.atualiza_ativo_manual_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.atualiza_ativo_manual_id_seq OWNER TO postgres;

--
-- Name: atualiza_ativo_manual_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.atualiza_ativo_manual_id_seq OWNED BY public.atualiza_ativo_manual.id;


--
-- Name: atualiza_nu; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.atualiza_nu (
    id integer NOT NULL,
    valor_bruto_antigo numeric NOT NULL,
    valor_liquido_antigo numeric NOT NULL,
    operacoes_import_id integer NOT NULL,
    itens_ativo_id integer NOT NULL
);


ALTER TABLE public.atualiza_nu OWNER TO postgres;

--
-- Name: atualiza_nu_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.atualiza_nu_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.atualiza_nu_id_seq OWNER TO postgres;

--
-- Name: atualiza_nu_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.atualiza_nu_id_seq OWNED BY public.atualiza_nu.id;


--
-- Name: atualiza_operacoes_manual; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.atualiza_operacoes_manual (
    id integer NOT NULL,
    valor_bruto numeric NOT NULL,
    valor_liquido numeric NOT NULL,
    atualiza_ativo_manual_id integer NOT NULL,
    data timestamp without time zone NOT NULL
);


ALTER TABLE public.atualiza_operacoes_manual OWNER TO postgres;

--
-- Name: atualiza_operacoes_manual_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.atualiza_operacoes_manual_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.atualiza_operacoes_manual_id_seq OWNER TO postgres;

--
-- Name: atualiza_operacoes_manual_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.atualiza_operacoes_manual_id_seq OWNED BY public.atualiza_operacoes_manual.id;


--
-- Name: auditoria; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.auditoria (
    id integer NOT NULL,
    model text NOT NULL,
    operacao text NOT NULL,
    changes jsonb NOT NULL,
    user_id integer NOT NULL,
    created_at integer NOT NULL
);


ALTER TABLE public.auditoria OWNER TO postgres;

--
-- Name: auditoria_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.auditoria_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.auditoria_id_seq OWNER TO postgres;

--
-- Name: auditoria_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.auditoria_id_seq OWNED BY public.auditoria.id;


--
-- Name: auth_assignment; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.auth_assignment (
    item_name character varying(64) NOT NULL,
    user_id integer NOT NULL,
    created_at integer
);


ALTER TABLE public.auth_assignment OWNER TO postgres;

--
-- Name: auth_item; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.auth_item (
    name character varying(64) NOT NULL,
    type smallint NOT NULL,
    description text,
    rule_name character varying(64),
    data bytea,
    created_at integer,
    updated_at integer
);


ALTER TABLE public.auth_item OWNER TO postgres;

--
-- Name: auth_item_child; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.auth_item_child (
    parent character varying(64) NOT NULL,
    child character varying(64) NOT NULL
);


ALTER TABLE public.auth_item_child OWNER TO postgres;

--
-- Name: auth_rule; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.auth_rule (
    name character varying(64) NOT NULL,
    data bytea,
    created_at integer,
    updated_at integer
);


ALTER TABLE public.auth_rule OWNER TO postgres;

--
-- Name: classes_operacoes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.classes_operacoes (
    id integer NOT NULL,
    nome character varying(255) NOT NULL
);


ALTER TABLE public.classes_operacoes OWNER TO postgres;

--
-- Name: classes_operacoes_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.classes_operacoes_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.classes_operacoes_id_seq OWNER TO postgres;

--
-- Name: classes_operacoes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.classes_operacoes_id_seq OWNED BY public.classes_operacoes.id;


--
-- Name: investidor; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.investidor (
    id integer NOT NULL,
    cpf character varying(11) NOT NULL,
    nome text NOT NULL
);


ALTER TABLE public.investidor OWNER TO postgres;

--
-- Name: investidor_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.investidor_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.investidor_id_seq OWNER TO postgres;

--
-- Name: investidor_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.investidor_id_seq OWNED BY public.investidor.id;


--
-- Name: itens_ativo; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.itens_ativo (
    id integer NOT NULL,
    ativo_id integer NOT NULL,
    investidor_id integer NOT NULL,
    quantidade numeric,
    valor_compra numeric,
    valor_liquido numeric,
    valor_bruto numeric,
    ativo boolean
);


ALTER TABLE public.itens_ativo OWNER TO postgres;

--
-- Name: itens_ativo_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.itens_ativo_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.itens_ativo_id_seq OWNER TO postgres;

--
-- Name: itens_ativo_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.itens_ativo_id_seq OWNED BY public.itens_ativo.id;


--
-- Name: migration; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.migration (
    version character varying(180) NOT NULL,
    apply_time integer
);


ALTER TABLE public.migration OWNER TO postgres;

--
-- Name: operacao; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.operacao (
    id integer NOT NULL,
    quantidade numeric NOT NULL,
    valor real NOT NULL,
    data timestamp without time zone NOT NULL,
    tipo integer NOT NULL,
    itens_ativos_id integer
);


ALTER TABLE public.operacao OWNER TO postgres;

--
-- Name: operacao_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.operacao_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.operacao_id_seq OWNER TO postgres;

--
-- Name: operacao_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.operacao_id_seq OWNED BY public.operacao.id;


--
-- Name: operacoes_import; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.operacoes_import (
    id integer NOT NULL,
    investidor_id integer NOT NULL,
    arquivo text NOT NULL,
    extensao text NOT NULL,
    tipo_arquivo text NOT NULL,
    hash_nome text NOT NULL,
    data timestamp without time zone NOT NULL,
    lista_operacoes_criadas_json text
);


ALTER TABLE public.operacoes_import OWNER TO postgres;

--
-- Name: operacoes_import_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.operacoes_import_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.operacoes_import_id_seq OWNER TO postgres;

--
-- Name: operacoes_import_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.operacoes_import_id_seq OWNED BY public.operacoes_import.id;


--
-- Name: preco; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.preco (
    id integer NOT NULL,
    valor numeric NOT NULL,
    ativo_id integer,
    data timestamp(0) without time zone NOT NULL,
    atualiza_acoes_id integer
);


ALTER TABLE public.preco OWNER TO postgres;

--
-- Name: preco_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.preco_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.preco_id_seq OWNER TO postgres;

--
-- Name: preco_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.preco_id_seq OWNED BY public.preco.id;


--
-- Name: proventos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.proventos (
    id integer NOT NULL,
    data timestamp without time zone NOT NULL,
    valor real NOT NULL,
    itens_ativos_id integer,
    movimentacao integer
);


ALTER TABLE public.proventos OWNER TO postgres;

--
-- Name: proventos_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.proventos_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.proventos_id_seq OWNER TO postgres;

--
-- Name: proventos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.proventos_id_seq OWNED BY public.proventos.id;


--
-- Name: site_acoes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.site_acoes (
    ativo_id integer NOT NULL,
    url text NOT NULL
);


ALTER TABLE public.site_acoes OWNER TO postgres;

--
-- Name: user; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."user" (
    id integer NOT NULL,
    username character varying(50) NOT NULL,
    password text NOT NULL,
    authkey text
);


ALTER TABLE public."user" OWNER TO postgres;

--
-- Name: user_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.user_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.user_id_seq OWNER TO postgres;

--
-- Name: user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.user_id_seq OWNED BY public."user".id;


--
-- Name: acao_bolsa id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.acao_bolsa ALTER COLUMN id SET DEFAULT nextval('public.acao_bolsa_id_seq'::regclass);


--
-- Name: ativo id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ativo ALTER COLUMN id SET DEFAULT nextval('public.ativo_id_seq'::regclass);


--
-- Name: atualiza_acoes id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.atualiza_acoes ALTER COLUMN id SET DEFAULT nextval('public.atualiza_acoes_id_seq'::regclass);


--
-- Name: atualiza_ativo_manual id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.atualiza_ativo_manual ALTER COLUMN id SET DEFAULT nextval('public.atualiza_ativo_manual_id_seq'::regclass);


--
-- Name: atualiza_nu id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.atualiza_nu ALTER COLUMN id SET DEFAULT nextval('public.atualiza_nu_id_seq'::regclass);


--
-- Name: atualiza_operacoes_manual id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.atualiza_operacoes_manual ALTER COLUMN id SET DEFAULT nextval('public.atualiza_operacoes_manual_id_seq'::regclass);


--
-- Name: auditoria id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.auditoria ALTER COLUMN id SET DEFAULT nextval('public.auditoria_id_seq'::regclass);


--
-- Name: classes_operacoes id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.classes_operacoes ALTER COLUMN id SET DEFAULT nextval('public.classes_operacoes_id_seq'::regclass);


--
-- Name: investidor id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.investidor ALTER COLUMN id SET DEFAULT nextval('public.investidor_id_seq'::regclass);


--
-- Name: itens_ativo id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.itens_ativo ALTER COLUMN id SET DEFAULT nextval('public.itens_ativo_id_seq'::regclass);


--
-- Name: operacao id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.operacao ALTER COLUMN id SET DEFAULT nextval('public.operacao_id_seq'::regclass);


--
-- Name: operacoes_import id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.operacoes_import ALTER COLUMN id SET DEFAULT nextval('public.operacoes_import_id_seq'::regclass);


--
-- Name: preco id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.preco ALTER COLUMN id SET DEFAULT nextval('public.preco_id_seq'::regclass);


--
-- Name: proventos id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.proventos ALTER COLUMN id SET DEFAULT nextval('public.proventos_id_seq'::regclass);


--
-- Name: user id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."user" ALTER COLUMN id SET DEFAULT nextval('public.user_id_seq'::regclass);


--
-- Data for Name: acao_bolsa; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.acao_bolsa (id, nome, codigo, setor, cnpj, tag_along_on, free_float, governo, rank_ano, rank_trimestre, data_atualizacao_rank, habilita_rank) FROM stdin;
7	Aliansce	ALSC	Shoppings	06.082.980/0001-03	\N	\N	\N	0	0	\N	t
26	BR Pharma	BPHA	Produtos Farmacêuticos	11.395.624/0001-71	\N	\N	\N	0	0	\N	t
29	Brasil Insurance	BRIN	Seguros	11.721.921/0001-60	\N	\N	\N	0	0	\N	t
89	Itautec	ITEC	Tecnologia Bancária	54.526.082/0001-31	\N	\N	\N	0	0	\N	t
12	Azul	AZUL	Aéreo	09.305.994/0001-29	\N	\N	\N	87.844	9.119	2020-04-05 11:56:43	t
187	Excelsior	BAUH	Carnes e Derivados	95.426.862/0001-97	\N	\N	\N	0.406	0.1	2020-04-05 11:56:43	t
207	Cedro Têxtil	CEDO	Têxtil	17.245.234/0001-00	\N	\N	\N	0.787	0.138	2020-04-05 11:56:43	t
40	Ceg	CEGR	Gás	33.938.119/0001-69	\N	\N	\N	9.256	1.381	2020-04-05 11:56:43	t
211	Celpe	CEPE	Energia	10.835.932/0001-08	\N	\N	\N	10.621	3.794	2020-04-05 11:56:43	t
118	Multiplus	MPLU	Programas de Fidelidade	11.094.546/0001-75	\N	\N	\N	0	0	\N	t
150	Somos Educação	SEDU	Educação	02.541.982/0001-54	\N	\N	\N	0	0	\N	t
158	Sierra Brasil	SSBR	Shoppings	05.878.397/0001-32	\N	\N	\N	0	0	\N	t
32	Biosev	BSEV	Açúcar e Álcool	15.527.906/0001-36	\N	\N	\N	30.638	0.257	2020-04-05 11:56:43	t
201	Banco de Brasília	BSLI	Bancos	00.000.208/0001-00	\N	\N	\N	4.979	0.777	2020-04-05 11:56:43	t
33	B2W Digital	BTOW	Comércio Varejista	00.776.574/0001-56	\N	\N	\N	39.243	13.26	2020-04-05 11:56:43	t
202	Battistella	BTTL	Holding	42.331.462/0001-31	\N	\N	\N	0.331	0.591	2020-04-05 11:56:43	t
203	Adolpho Lindenberg	CALI	Construção Civil	61.022.042/0001-18	\N	\N	\N	0.184	0.033	2020-04-05 11:56:43	t
204	Cambuci	CAMB	Calçados	61.088.894/0001-08	\N	\N	\N	0.45	0.039	2020-04-05 11:56:43	t
34	Camil	CAML	Alimentos	64.904.295/0001-03	\N	\N	\N	17.61	5.951	2020-04-05 11:56:43	t
35	CSU Cardsystem	CARD	Software	01.896.779/0001-38	\N	\N	\N	1.135	0.162	2020-04-05 11:56:43	t
205	Casan	CASN	Saneamento	82.508.433/0001-17	\N	\N	\N	2.895	1.321	2020-04-05 11:56:43	t
36	Ampla Energia	CBEE	Energia	33.050.071/0001-58	\N	\N	\N	12.466	4.766	2020-04-05 11:56:43	t
37	Cyrela Commercial	CCPR	Exploração de Imóveis	08.801.621/0001-86	\N	\N	\N	10.525	2.732	2020-04-05 11:56:43	t
38	CCR	CCRO	Exploração de Rodovias	02.846.056/0001-97	\N	\N	\N	52.638	21.01	2020-04-05 11:56:43	t
39	CCX Carvão	CCXC	Mineração	07.950.674/0001-04	\N	\N	\N	0.427	0.697	2020-04-05 11:56:43	t
206	Cia Energética de Brasília	CEBR	Energia	00.070.698/0001-11	\N	\N	\N	4.097	0.759	2020-04-05 11:56:43	t
208	Coelba	CEEB	Energia	15.139.629/0001-94	\N	\N	\N	18.128	8.614	2020-04-05 11:56:43	t
209	CEEE	CEED	Energia	08.467.115/0001-00	\N	\N	\N	12.62	1.934	2020-04-05 11:56:43	t
210	Celpa	CELP	Energia	04.895.728/0001-80	\N	\N	\N	0	0	\N	t
259	Mendes Júnior	MEND	Construção Civil	17.162.082/0001-73	\N	\N	\N	0	0	\N	t
239	Forja Taurus	FJTA	Armas e Equipamentos	92.781.335/0001-02	\N	\N	\N	0	0	\N	t
96	Kroton	KROT	Educação	02.800.026/0001-40	\N	\N	\N	0	0	\N	t
296	Tectoy	TOYB	Brinquedos e Jogos	22.770.366/0001-82	\N	\N	\N	0	0	\N	t
2	Banco ABC	ABCB	Bancos	28.195.667/0001-06	\N	\N	\N	13.711	2.786	2020-04-05 11:56:43	t
1	Alliar	AALR	Medicina Diagnóstica	42.771.949/0001-35	\N	\N	\N	10.332	1.115	2020-04-05 11:56:43	t
3	Ambev	ABEV	Bebidas	07.526.557/0001-00	\N	\N	\N	269.149	41.308	2020-04-05 11:56:43	t
4	Advanced Digital Health	ADHM	Medicina Diagnóstica	10.345.009/0001-98	\N	\N	\N	0.259	0.128	2020-04-05 11:56:43	t
5	Afluente T	AFLT	Energia	10.338.320/0001-00	\N	\N	\N	0.28	0.063	2020-04-05 11:56:43	t
6	BrasilAgro	AGRO	Agricultura	07.628.528/0001-59	\N	\N	\N	0.041	0.701	2020-04-05 11:56:43	t
182	São Paulo Turismo	AHEB	Eventos e Shows	62.002.886/0001-60	\N	\N	\N	0.298	0.033	2020-04-05 11:56:43	t
183	Alpargatas	ALPA	Calçados	61.079.117/0001-05	\N	\N	\N	9.999	1.427	2020-04-05 11:56:43	t
184	Alupar	ALUP	Energia	08.364.948/0001-38	\N	\N	\N	34.577	9.672	2020-04-05 11:56:43	t
8	Lojas Marisa	AMAR	Vestuário	61.189.288/0001-89	\N	\N	\N	5.185	0.357	2020-04-05 11:56:43	t
9	Anima	ANIM	Educação	09.288.252/0001-32	\N	\N	\N	7.596	1.232	2020-04-05 11:56:43	t
10	Arezzo	ARZZ	Calçados	16.590.234/0001-76	\N	\N	\N	7.112	0.783	2020-04-05 11:56:43	t
11	Atom	ATOM	Mesa Proprietária de Traders	00.359.742/0001-08	\N	\N	\N	0.563	0.144	2020-04-05 11:56:43	t
185	Azevedo Travassos	AZEV	Construção Civil	61.351.532/0001-68	\N	\N	\N	0.551	0.08	2020-04-05 11:56:43	t
13	B3	B3SA	Bolsa de Valores	09.346.601/0001-25	\N	\N	\N	67.062	13.556	2020-04-05 11:56:43	t
14	Bahema	BAHI	Educação	45.987.245/0001-92	\N	\N	\N	0.135	0.238	2020-04-05 11:56:43	t
186	Baumer	BALM	Implantes Ortopédicos	61.374.161/0001-30	\N	\N	\N	0.386	0.075	2020-04-05 11:56:43	t
15	Banco da Amazônia	BAZA	Bancos	04.902.979/0001-44	\N	\N	\N	4.299	0.349	2020-04-05 11:56:43	t
16	Banco do Brasil	BBAS	Bancos	00.000.000/0001-91	\N	\N	\N	325.994	49.032	2020-04-05 11:56:43	t
188	Banco Bradesco	BBDC	Bancos	60.746.948/0001-12	\N	\N	\N	327.638	80.755	2020-04-05 11:56:43	t
17	Brasil Brokers	BBRK	Exploração de Imóveis	08.613.550/0001-98	\N	\N	\N	0.81	0.819	2020-04-05 11:56:43	t
190	Banestes	BEES	Bancos	28.127.603/0001-78	\N	\N	\N	4.976	1.072	2020-04-05 11:56:43	t
20	Banco Inter	BIDI	Bancos	00.416.968/0001-01	\N	\N	\N	15.154	7.241	2020-04-05 11:56:43	t
200	Banrisul	BRSR	Bancos	92.702.067/0001-96	\N	\N	\N	24.237	4.398	2020-04-05 11:56:43	t
212	Cesp	CESP	Energia	60.933.603/0001-78	\N	\N	\N	10.587	6.28	2020-04-05 11:56:44	t
213	Comgás	CGAS	Gás	61.856.571/0001-17	\N	\N	\N	20.545	5.822	2020-04-05 11:56:44	t
214	Grazziotin	CGRA	Vestuário	92.012.467/0001-70	\N	\N	\N	1.817	0.375	2020-04-05 11:56:44	t
41	Cielo	CIEL	Meios de Pagamento	01.027.058/0001-91	\N	\N	\N	98.979	30.107	2020-04-05 11:56:44	t
215	Celesc	CLSC	Energia	83.878.892/0001-55	\N	\N	\N	11.92	1.682	2020-04-05 11:56:44	t
216	Cemig	CMIG	Energia	17.155.730/0001-64	\N	\N	\N	51.134	4.517	2020-04-05 11:56:44	t
42	Centauro	CNTO	Vestuário	13.217.485/0001-11	\N	\N	\N	18.976	11.938	2020-04-05 11:56:44	t
217	Coelce	COCE	Energia	07.047.251/0001-70	\N	\N	\N	10.689	3.03	2020-04-05 11:56:44	t
43	CPFL Energia	CPFE	Energia	02.429.144/0001-93	\N	\N	\N	74.36	16.901	2020-04-05 11:56:44	t
218	Copel	CPLE	Energia	76.483.817/0001-20	\N	\N	\N	43.561	14.863	2020-04-05 11:56:44	t
18	BB Seguridade	BBSE	Seguros	17.344.597/0001-94	\N	\N	\N	54.511	9.427	2020-04-05 11:56:43	t
189	Bardella	BDLL	Máquinas e Equipamentos	60.851.615/0001-53	\N	\N	\N	0.331	0.383	2020-04-05 11:56:43	t
19	Minerva	BEEF	Carnes e Derivados	67.620.377/0001-14	\N	\N	\N	44.622	14.186	2020-04-05 11:56:43	t
191	Banese	BGIP	Bancos	13.009.717/0001-46	\N	\N	\N	1.447	0.216	2020-04-05 11:56:43	t
21	Biomm	BIOM	Medicamentos	04.752.991/0001-10	\N	\N	\N	0.877	0.314	2020-04-05 11:56:43	t
22	Burger King	BKBR	Restaurantes	13.574.594/0001-96	\N	\N	\N	27.998	3.709	2020-04-05 11:56:43	t
192	Banco Mercantil	BMEB	Bancos	17.184.037/0001-10	\N	\N	\N	4.307	0.069	2020-04-05 11:56:43	t
193	Mercantil Investimentos	BMIN	Bancos	34.169.557/0001-72	\N	\N	\N	0.141	0.088	2020-04-05 11:56:43	t
23	Monark	BMKS	Bicicletas	56.992.423/0001-90	\N	\N	\N	0.191	0.101	2020-04-05 11:56:43	t
25	Banco Pan	BPAN	Bancos	59.285.411/0001-13	\N	\N	\N	22.636	3.765	2020-04-05 11:56:43	t
30	BR Malls	BRML	Shoppings	06.977.745/0001-91	\N	\N	\N	31.211	3.642	2020-04-05 11:56:43	t
31	BRProperties	BRPR	Exploração de Imóveis	06.977.751/0001-49	\N	\N	\N	17.776	1.285	2020-04-05 11:56:43	t
44	CPFL Renováveis	CPRE	Energia	08.439.659/0001-50	\N	\N	\N	24.312	4.176	2020-04-05 11:56:44	t
45	CR2	CRDE	Construção Civil	07.820.907/0001-46	\N	\N	\N	1.206	0.561	2020-04-05 11:56:44	t
46	Carrefour	CRFB	Comércio Varejista	75.315.333/0001-09	\N	\N	\N	223.093	29.871	2020-04-05 11:56:44	t
219	Alfa Financeira	CRIV	Financeira	17.167.412/0001-13	\N	\N	\N	1.948	0.249	2020-04-05 11:56:44	t
220	Cristal	CRPG	Químicos	15.115.504/0001-24	\N	\N	\N	1.078	0.373	2020-04-05 11:56:44	t
221	Seguro Aliança	CSAB	Seguros	15.144.017/0001-90	\N	\N	\N	0.451	0.062	2020-04-05 11:56:44	t
47	Cosan	CSAN	Petróleo, Gás e Biocombustíveis	50.746.577/0001-15	\N	\N	\N	62.969	6.512	2020-04-05 11:56:44	t
48	Copasa	CSMG	Saneamento	17.281.106/0001-03	\N	\N	\N	20.073	3.089	2020-04-05 11:56:44	t
49	CSN	CSNA	Siderurgia	33.042.730/0001-04	\N	\N	\N	48.125	4.677	2020-04-05 11:56:44	t
222	Cosern	CSRN	Energia	08.324.196/0001-81	\N	\N	\N	5.237	1.554	2020-04-05 11:56:44	t
223	Karsten	CTKA	Têxtil	82.640.558/0001-04	\N	\N	\N	0.482	0.272	2020-04-05 11:56:44	t
224	Coteminas	CTNM	Têxtil	22.677.520/0001-76	\N	\N	\N	4.686	0.417	2020-04-05 11:56:44	t
225	Santanense	CTSA	Têxtil	21.255.567/0001-89	\N	\N	\N	0.925	0.23	2020-04-05 11:56:44	t
50	CVC	CVCB	Viagens e Turismo	10.760.260/0001-19	\N	\N	\N	9.347	3.797	2020-04-05 11:56:44	t
51	Cyrela Realty	CYRE	Construção Civil	73.178.600/0001-18	\N	\N	\N	21.579	1.823	2020-04-05 11:56:44	t
52	Dasa	DASA	Medicina Diagnóstica	61.486.650/0001-83	\N	\N	\N	17.703	3.059	2020-04-05 11:56:44	t
53	Direcional	DIRR	Construção Civil	16.614.075/0001-00	\N	\N	\N	9.381	0.579	2020-04-05 11:56:44	t
54	Dommo	DMMO	Petróleo, Gás e Biocombustíveis	08.926.302/0001-05	\N	\N	\N	147.212	29.609	2020-04-05 11:56:44	t
226	Dohler	DOHL	Têxtil	84.683.408/0001-03	\N	\N	\N	1.063	0.222	2020-04-05 11:56:44	t
227	DTCOM	DTCY	Educação	03.303.999/0001-36	\N	\N	\N	0.573	0.03	2020-04-05 11:56:44	t
55	Duratex	DTEX	Produtos para Construção Civil	97.837.181/0001-47	\N	\N	\N	26.238	1.821	2020-04-05 11:56:44	t
228	Electro Aço Altona	EALT	Máquinas e Equipamentos	82.643.537/0001-34	\N	\N	\N	0.581	0.143	2020-04-05 11:56:44	t
56	Ecorodovias	ECOR	Exploração de Rodovias	04.149.454/0001-80	\N	\N	\N	16.88	0.55	2020-04-05 11:56:44	t
229	CEEE-GT	EEEL	Energia	92.715.812/0001-31	\N	\N	\N	4.739	1.097	2020-04-05 11:56:44	t
57	Engie	EGIE	Energia	02.474.103/0001-19	\N	\N	\N	35.104	10.927	2020-04-05 11:56:44	t
230	Elektro	EKTR	Energia	02.328.280/0001-97	\N	\N	\N	11.326	4.216	2020-04-05 11:56:44	t
231	Elekeiroz	ELEK	Químicos	13.788.120/0001-47	\N	\N	\N	1.82	0.065	2020-04-05 11:56:44	t
232	Eletrobras	ELET	Energia	00.001.180/0001-26	\N	\N	\N	47.797	13.102	2020-04-05 11:56:44	t
58	Eletropaulo	ELPL	Energia	61.695.227/0001-93	\N	\N	\N	12.636	2.556	2020-04-05 11:56:44	t
233	Emae	EMAE	Energia	02.302.101/0001-42	\N	\N	\N	0.258	0.435	2020-04-05 11:56:44	t
59	Embraer	EMBR	Produção de Aerovanes	07.689.002/0001-89	\N	\N	\N	53.206	15.583	2020-04-05 11:56:44	t
60	Enauta	ENAT	Petróleo, Gás e Biocombustíveis	11.669.021/0001-10	\N	\N	\N	15.26	1.778	2020-04-05 11:56:44	t
66	Even	EVEN	Construção Civil	43.470.988/0001-65	\N	\N	\N	10.767	0.124	2020-04-05 11:56:44	t
67	Eztec	EZTC	Construção Civil	08.312.229/0001-73	\N	\N	\N	11.098	2.118	2020-04-05 11:56:44	t
238	Ferbasa	FESA	Siderurgia	15.141.799/0001-03	\N	\N	\N	4.946	1.224	2020-04-05 11:56:44	t
68	Heringer	FHER	Fertilizantes	22.266.175/0001-88	\N	\N	\N	9.763	0.636	2020-04-05 11:56:44	t
69	Fleury	FLRY	Medicina Diagnóstica	60.840.055/0001-31	\N	\N	\N	14.768	1.646	2020-04-05 11:56:44	t
70	Fras-le	FRAS	Material Rodoviário	88.610.126/0001-29	\N	\N	\N	2.919	0.77	2020-04-05 11:56:44	t
71	Metalfrio	FRIO	Máquinas e Equipamentos	04.821.041/0001-08	\N	\N	\N	2.79	0.429	2020-04-05 11:56:44	t
72	Pomi Frutas	FRTA	Agricultura	86.550.951/0001-50	\N	\N	\N	0.121	0.007	2020-04-05 11:56:44	t
240	Paranapanema Energia	GEPA	Energia	02.998.301/0001-81	\N	\N	\N	3.675	0.032	2020-04-05 11:56:44	t
74	Gafisa	GFSA	Construção Civil	01.545.826/0001-07	\N	\N	\N	7.863	6.611	2020-04-05 11:56:44	t
241	Gerdau	GGBR	Siderurgia	33.611.500/0001-19	\N	\N	\N	118.86	3.283	2020-04-05 11:56:44	t
75	NotreDame Intermédica	GNDI	Seguros	19.853.511/0001-84	\N	\N	\N	100.311	39.813	2020-04-05 11:56:44	t
242	Metalúrgica Gerdau	GOAU	Siderurgia	92.690.783/0001-09	\N	\N	\N	120.222	4.36	2020-04-05 11:56:44	t
61	Energias do Brasil	ENBR	Energia	03.983.431/0001-03	\N	\N	\N	42.633	11.462	2020-04-05 11:56:44	t
62	Eneva	ENEV	Energia	04.423.567/0001-21	\N	\N	\N	23.52	4.972	2020-04-05 11:56:44	t
234	Energisa	ENGI	Energia	00.864.214/0001-06	\N	\N	\N	43.332	21.91	2020-04-05 11:56:44	t
235	Energisa MT	ENMT	Energia	03.467.321/0001-99	\N	\N	\N	9.074	3.274	2020-04-05 11:56:44	t
63	Equatorial	EQTL	Energia	03.220.438/0001-73	\N	\N	\N	46.09	21.383	2020-04-05 11:56:44	t
236	Estrela	ESTR	Brinquedos e Jogos	61.082.004/0001-50	\N	\N	\N	0.661	0.286	2020-04-05 11:56:44	t
65	Eternit	ETER	Produtos para Construção Civil	61.092.037/0001-81	\N	\N	\N	0.888	0.441	2020-04-05 11:56:44	t
237	Eucatex	EUCA	Madeira	56.643.018/0001-66	\N	\N	\N	3.426	0.525	2020-04-05 11:56:44	t
243	Gol	GOLL	Aéreo	06.164.253/0001-87	\N	\N	\N	36.396	8.131	2020-04-05 11:56:44	t
76	Celg	GPAR	Energia	08.560.444/0001-93	\N	\N	\N	0.273	0.694	2020-04-05 11:56:44	t
244	GPC	GPCP	Químicos	02.193.750/0001-52	\N	\N	\N	0.627	0.085	2020-04-05 11:56:44	t
78	Grendene	GRND	Calçados	89.850.341/0001-60	\N	\N	\N	11.91	2.833	2020-04-05 11:56:44	t
79	General Shopping	GSHP	Shoppings	08.764.621/0001-53	\N	\N	\N	3.217	0.687	2020-04-05 11:56:44	t
80	Guararapes	GUAR	Vestuário	08.402.943/0001-52	\N	\N	\N	18.016	6.337	2020-04-05 11:56:44	t
245	Haga	HAGA	Produtos para Construção Civil	30.540.991/0001-66	\N	\N	\N	0.128	0.014	2020-04-05 11:56:44	t
81	Hapvida	HAPV	Seguros	05.197.443/0001-38	\N	\N	\N	88.928	41.479	2020-04-05 11:56:44	t
82	Helbor	HBOR	Construção Civil	49.263.189/0001-02	\N	\N	\N	7.667	1.308	2020-04-05 11:56:44	t
246	Habitasul	HBTS	Exploração de Imóveis	87.762.563/0001-03	\N	\N	\N	0.395	0.111	2020-04-05 11:56:44	t
247	Hercules	HETA	Utensílios Pessoais e Domésticos	92.749.225/0001-63	\N	\N	\N	0.643	0.261	2020-04-05 11:56:44	t
83	Cia Hering	HGTX	Vestuário	78.876.950/0001-71	\N	\N	\N	5.294	0.731	2020-04-05 11:56:44	t
248	Hotéis Othon	HOOT	Hotelaria	33.200.049/0001-47	\N	\N	\N	0.418	0.102	2020-04-05 11:56:44	t
84	Hypera Pharma	HYPE	Medicamentos	02.932.074/0001-91	\N	\N	\N	37.33	1.963	2020-04-05 11:56:44	t
85	Ideiasnet	IDNT	Holding	02.365.069/0001-44	\N	\N	\N	1.239	0.837	2020-04-05 11:56:44	t
249	Banco Indusval	IDVL	Bancos	61.024.352/0001-71	\N	\N	\N	0.748	0.391	2020-04-05 11:56:44	t
86	IGB Eletrônica	IGBR	Eletrodomésticos	43.185.362/0001-07	\N	\N	\N	0.632	0.404	2020-04-05 11:56:44	t
87	Iguatemi	IGTA	Shoppings	51.218.147/0001-93	\N	\N	\N	10.801	1.706	2020-04-05 11:56:44	t
250	Inepar	INEP	Máquinas e Equipamentos	76.627.504/0001-06	\N	\N	\N	1.585	0.49	2020-04-05 11:56:44	t
88	IRB Brasil	IRBR	Seguros	33.376.989/0001-91	\N	\N	\N	38.788	4.983	2020-04-05 11:56:44	t
251	Itaúsa	ITSA	Holding	61.532.644/0001-15	\N	\N	\N	103.735	40.207	2020-04-05 11:56:44	t
252	Banco Itaú	ITUB	Bancos	60.872.504/0001-23	\N	\N	\N	495.128	107.556	2020-04-05 11:56:44	t
253	JB Duarte	JBDU	Holding	60.637.238/0001-54	\N	\N	\N	0.04	0.004	2020-04-05 11:56:44	t
90	JBS	JBSS	Carnes e Derivados	02.916.265/0001-60	\N	\N	\N	547.864	90.245	2020-04-05 11:56:44	t
91	João Fortes	JFEN	Construção Civil	33.035.536/0001-00	\N	\N	\N	2.943	0.245	2020-04-05 11:56:44	t
92	JHSF	JHSF	Shoppings e Hotelaria	08.294.224/0001-65	\N	\N	\N	6.881	0.278	2020-04-05 11:56:44	t
254	Josapar	JOPA	Alimentos	87.456.562/0001-22	\N	\N	\N	2.381	1.026	2020-04-05 11:56:44	t
93	Jereissati	JPSA	Exploração de Imóveis	60.543.816/0001-93	\N	\N	\N	9.491	7.939	2020-04-05 11:56:44	t
94	JSL	JSLG	Logísitica e Rodoviário	52.548.435/0001-79	\N	\N	\N	41.477	15.632	2020-04-05 11:56:44	t
105	Log-in	LOGN	Hidroviário	42.278.291/0001-24	\N	\N	\N	2.082	0.318	2020-04-05 11:56:44	t
106	Lopes Brasil	LPSB	Exploração de Imóveis	08.078.847/0001-09	\N	\N	\N	0.59	0.945	2020-04-05 11:56:44	t
107	Lojas Renner	LREN	Vestuário	92.754.738/0001-62	\N	\N	\N	21.737	6.261	2020-04-05 11:56:44	t
108	Lupatech	LUPA	Equipamentos e Petróleo	89.463.822/0001-12	\N	\N	\N	0.019	0.832	2020-04-05 11:56:44	t
257	Trevisa	LUXM	Fertilizantes	92.660.570/0001-26	\N	\N	\N	0.352	0.072	2020-04-05 11:56:44	t
258	Cemepe Investimentos	MAPT	Holding	93.828.986/0001-73	\N	\N	\N	0.116	0.001	2020-04-05 11:56:44	t
109	M.Dias Branco	MDIA	Alimentos	07.206.816/0001-15	\N	\N	\N	24.146	5.572	2020-04-05 11:56:44	t
110	International Meal	MEAL	Restaurantes	17.314.329/0001-20	\N	\N	\N	11.067	0.057	2020-04-05 11:56:44	t
260	Mercantil Financeira	MERC	Financeira	33.040.601/0001-87	\N	\N	\N	0.523	0.084	2020-04-05 11:56:44	t
261	Magnels	MGEL	Siderurgia	61.065.298/0001-02	\N	\N	\N	0.827	0.042	2020-04-05 11:56:44	t
111	Magazine Luiza	MGLU	Comércio Varejista	47.960.950/0001-21	\N	\N	\N	64.528	7.089	2020-04-05 11:56:44	t
112	Mills	MILS	Construção e Engenharia	27.093.558/0001-15	\N	\N	\N	0.665	0.242	2020-04-05 11:56:44	t
113	MMX Miner	MMXM	Mineração	02.762.115/0001-49	\N	\N	\N	2.422	3.259	2020-04-05 11:56:44	t
114	Mundial	MNDL	Utensílios Pessoais e Domésticos	88.610.191/0001-54	\N	\N	\N	0.48	0.119	2020-04-05 11:56:44	t
115	Minupar	MNPR	Carnes e Derivados	90.076.886/0001-40	\N	\N	\N	0.656	0.225	2020-04-05 11:56:44	t
116	Monteiro Aranha	MOAR	Holding	33.102.476/0001-92	\N	\N	\N	10.136	1.432	2020-04-05 11:56:44	t
117	Movida	MOVI	Aluguel e Venda de Carros	21.314.559/0001-66	\N	\N	\N	46.033	11.069	2020-04-05 11:56:44	t
119	Marfrig	MRFG	Carnes e Derivados	03.853.896/0001-40	\N	\N	\N	84.962	13.277	2020-04-05 11:56:44	t
120	MRV Engenharia	MRVE	Construção Civil	08.343.492/0001-20	\N	\N	\N	27.242	2.045	2020-04-05 11:56:44	t
262	Melhoramentos SP	MSPA	Papel e Celulose e Editorial	60.730.348/0001-66	\N	\N	\N	1.607	0.29	2020-04-05 11:56:44	t
263	Metalgráfica Iguaçu	MTIG	Embalagens	80.227.184/0001-66	\N	\N	\N	0.043	0.034	2020-04-05 11:56:44	t
264	Metisa	MTSA	Máquinas e Equipamentos	86.375.425/0001-09	\N	\N	\N	0.857	0.004	2020-04-05 11:56:44	t
121	Multiplan	MULT	Shoppings	07.816.890/0001-53	\N	\N	\N	16.743	4.747	2020-04-05 11:56:44	t
265	Wetzel	MWET	Automotivo	84.683.671/0001-94	\N	\N	\N	0.384	0.189	2020-04-05 11:56:44	t
122	Iochpe-Maxion	MYPK	Automotivo	61.156.113/0001-75	\N	\N	\N	17.436	4.804	2020-04-05 11:56:44	t
123	Natura	NATU	Cosméticos	71.673.990/0001-77	\N	\N	\N	30.28	10.651	2020-04-05 11:56:44	t
124	Nordon	NORD	Máquinas e Equipamentos	60.884.319/0001-59	\N	\N	\N	0.037	0.091	2020-04-05 11:56:44	t
266	Oderich	ODER	Alimentos	97.191.902/0001-94	\N	\N	\N	0.845	0.124	2020-04-05 11:56:44	t
125	Odontoprev	ODPV	Seguros	58.119.199/0001-51	\N	\N	\N	8.088	0.941	2020-04-05 11:56:44	t
126	Ouro Fino	OFSA	Medicamentos	20.258.278/0001-70	\N	\N	\N	2.53	0.504	2020-04-05 11:56:44	t
267	Oi	OIBR	Telecomunicações	76.535.764/0001-43	\N	\N	\N	95.733	20.252	2020-04-05 11:56:44	t
127	Omega Geração	OMGE	Energia	09.149.503/0001-06	\N	\N	\N	16.205	4.683	2020-04-05 11:56:44	t
128	OSX Brasil	OSXB	Petróleo, Gás e Biocombustíveis	09.112.685/0001-32	\N	\N	\N	13.576	0.055	2020-04-05 11:56:44	t
129	Hermes Pardini	PARD	Medicina Diagnóstica	19.378.769/0001-76	\N	\N	\N	7.746	0.146	2020-04-05 11:56:44	t
268	Panatlântica	PATI	Siderurgia	92.693.019/0001-89	\N	\N	\N	2.052	0.628	2020-04-05 11:56:44	t
269	Pão de Açucar	PCAR	Comércio Varejista	47.508.411/0001-56	\N	\N	\N	106.28	1.335	2020-04-05 11:56:44	t
130	PDG Realty	PDGR	Construção Civil	02.950.811/0001-89	\N	\N	\N	9.435	10.456	2020-04-05 11:56:44	t
270	Participações Aliança	PEAB	Holding	01.938.783/0001-11	\N	\N	\N	1.188	0.183	2020-04-05 11:56:44	t
271	Petrobras	PETR	Petróleo, Gás e Biocombustíveis	33.000.167/0001-01	\N	\N	\N	1280.725	172.126	2020-04-05 11:56:44	t
131	Profarma	PFRM	Produtos Farmacêuticos	45.453.214/0001-51	\N	\N	\N	7.895	1.374	2020-04-05 11:56:44	t
272	Banco Pine	PINE	Bancos	62.144.175/0001-20	\N	\N	\N	1.959	0.404	2020-04-05 11:56:44	t
132	Plascar	PLAS	Automotivo	51.928.174/0001-50	\N	\N	\N	1.144	0.297	2020-04-05 11:56:44	t
133	Paranapanema	PMAM	Siderurgia	60.398.369/0004-79	\N	\N	\N	7.322	0.108	2020-04-05 11:56:44	t
273	Dimed	PNVL	Medicamentos	92.665.611/0001-77	\N	\N	\N	3.468	0.834	2020-04-05 11:56:44	t
274	Marcopolo	POMO	Material Rodoviário	88.611.835/0001-29	\N	\N	\N	9.692	1.94	2020-04-05 11:56:44	t
134	Positivo	POSI	Hardware	81.243.735/0001-48	\N	\N	\N	4.387	0.255	2020-04-05 11:56:44	t
135	Petrorio	PRIO	Petróleo, Gás e Biocombustíveis	10.629.105/0001-68	\N	\N	\N	1.722	2.75	2020-04-05 11:56:44	t
136	Porto Seguro	PSSA	Seguros	02.149.205/0001-69	\N	\N	\N	54.766	8.082	2020-04-05 11:56:44	t
137	Portobello	PTBL	Cerâmicos	83.475.913/0001-91	\N	\N	\N	2.198	1.041	2020-04-05 11:56:44	t
148	Sabesp	SBSP	Saneamento	43.776.517/0001-80	\N	\N	\N	43.337	17.318	2020-04-05 11:56:44	t
149	São Carlos	SCAR	Exploração de Imóveis	29.780.061/0001-09	\N	\N	\N	3.067	0.915	2020-04-05 11:56:44	t
151	SER Educacional	SEER	Educação	04.986.320/0001-13	\N	\N	\N	14.061	2.826	2020-04-05 11:56:44	t
152	Springs Global	SGPS	Têxtil	07.718.269/0001-57	\N	\N	\N	6.328	0.305	2020-04-05 11:56:44	t
153	Time For Fun	SHOW	Eventos e Shows	02.860.694/0001-62	\N	\N	\N	0.924	0.058	2020-04-05 11:56:44	t
284	Schulz	SHUL	Automotivo e Compressores	84.693.183/0001-68	\N	\N	\N	2.504	0.668	2020-04-05 11:56:44	t
154	SLC Agrícola	SLCE	Agricultura	89.096.457/0001-55	\N	\N	\N	14.86	3.233	2020-04-05 11:56:44	t
285	Saraiva	SLED	Comércio Varejista	60.500.139/0001-26	\N	\N	\N	3.372	0.412	2020-04-05 11:56:44	t
286	Smart Fit	SMFT	Academias	07.594.978/0001-78	\N	\N	\N	34.767	13.499	2020-04-05 11:56:44	t
155	Smiles	SMLS	Programas de Fidelidade	05.730.375/0001-20	\N	\N	\N	11.467	2.595	2020-04-05 11:56:44	t
156	São Martinho	SMTO	Açúcar e Álcool	51.466.860/0001-56	\N	\N	\N	20.529	7.258	2020-04-05 11:56:44	t
287	Sondotécnica	SOND	Consultoria e Engenharia	33.386.210/0001-19	\N	\N	\N	0.314	0.111	2020-04-05 11:56:44	t
288	Springer	SPRI	Eletrodomésticos	92.929.520/0001-00	\N	\N	\N	0.08	0.173	2020-04-05 11:56:44	t
157	Sinqia	SQIA	Software	04.065.791/0001-99	\N	\N	\N	1.479	0.315	2020-04-05 11:56:44	t
159	Santos Brasil	STBP	Logística e Portuário	02.762.121/0001-04	\N	\N	\N	0.04	0.391	2020-04-05 11:56:44	t
289	Sulamerica	SULA	Seguros	29.978.814/0001-87	\N	\N	\N	67.544	16.289	2020-04-05 11:56:44	t
160	Suzano Papel	SUZB	Papel e Celulose	16.404.287/0001-55	\N	\N	\N	61.917	51.887	2020-04-05 11:56:44	t
290	Taesa	TAEE	Energia	07.859.971/0001-30	\N	\N	\N	19	2.833	2020-04-05 11:56:44	t
291	Tecnosolo	TCNO	Consultoria e Engenharia	33.111.246/0001-90	\N	\N	\N	0.121	0.094	2020-04-05 11:56:44	t
161	Tecnisa	TCSA	Construção Civil	08.065.557/0001-12	\N	\N	\N	2.349	2.466	2020-04-05 11:56:44	t
162	Technos	TECN	Relógios	09.295.063/0001-97	\N	\N	\N	1.421	0.106	2020-04-05 11:56:44	t
292	Teka	TEKA	Têxtil	82.636.986/0001-55	\N	\N	\N	1.822	0.88	2020-04-05 11:56:44	t
293	Telebrás	TELB	Telecomunicações	00.336.701/0001-04	\N	\N	\N	3.239	0.689	2020-04-05 11:56:44	t
163	Tenda	TEND	Construção Civil	71.476.527/0001-35	\N	\N	\N	6.746	0.524	2020-04-05 11:56:44	t
164	Terra Santa	TESA	Agricultura	05.799.312/0001-20	\N	\N	\N	3.515	0.344	2020-04-05 11:56:44	t
165	Tegma	TGMA	Automotivo e Logística	02.351.144/0001-18	\N	\N	\N	2.995	0.091	2020-04-05 11:56:44	t
294	AES Tietê	TIET	Energia	04.128.563/0001-10	\N	\N	\N	38.534	11.19	2020-04-05 11:56:44	t
166	TIM	TIMP	Telecomunicações	02.558.115/0001-21	\N	\N	\N	93.993	8.605	2020-04-05 11:56:44	t
295	Tekno	TKNO	Siderurgia	33.467.572/0001-34	\N	\N	\N	0.405	0.195	2020-04-05 11:56:44	t
167	Totvs	TOTS	Software	53.113.791/0001-22	\N	\N	\N	10.375	1.661	2020-04-05 11:56:44	t
168	Triunfo	TPIS	Exploração de Rodovias	03.014.553/0001-91	\N	\N	\N	1.351	0.55	2020-04-05 11:56:44	t
169	Trisul	TRIS	Construção Civil	08.811.643/0001-27	\N	\N	\N	0.948	0.456	2020-04-05 11:56:44	t
297	Trans Paulista	TRPL	Energia	02.998.611/0001-04	\N	\N	\N	27.486	10.51	2020-04-05 11:56:44	t
171	Tupy	TUPY	Material Rodoviário	84.683.374/0001-49	\N	\N	\N	10.993	1.684	2020-04-05 11:56:44	t
298	Renauxview	TXRX	Vestuário	82.982.075/0001-80	\N	\N	\N	1.339	0.407	2020-04-05 11:56:44	t
172	Unicasa	UCAS	Móveis	90.441.460/0001-48	\N	\N	\N	0.935	0.107	2020-04-05 11:56:44	t
173	Ultrapar	UGPA	Petróleo, Gás e Biocombustíveis	33.256.439/0001-39	\N	\N	\N	152.715	26.072	2020-04-05 11:56:44	t
299	Unipar	UNIP	Soda, Cloro e Derivados	33.958.695/0001-78	\N	\N	\N	4.263	2.901	2020-04-05 11:56:44	t
275	Pettenati	PTNT	Têxtil	88.613.658/0001-10	\N	\N	\N	0.864	0.251	2020-04-05 11:56:44	t
138	Qualicorp	QUAL	Seguros	11.992.680/0001-93	\N	\N	\N	12.959	2.06	2020-04-05 11:56:44	t
139	RaiaDrogasil	RADL	Produtos Farmacêuticos	61.585.865/0001-51	\N	\N	\N	25.067	6.503	2020-04-05 11:56:44	t
140	Rumo Log	RAIL	Logística e Ferroviário	02.387.241/0001-60	\N	\N	\N	31.182	9.153	2020-04-05 11:56:44	t
276	Celulose Irani	RANI	Papel e Celulose	92.791.243/0001-03	\N	\N	\N	2.53	0.432	2020-04-05 11:56:44	t
277	Randon	RAPT	Material Rodoviário	89.086.144/0001-16	\N	\N	\N	12.249	1.72	2020-04-05 11:56:44	t
278	Recrusul	RCSL	Material Rodoviário	91.333.666/0001-17	\N	\N	\N	0.02	0.057	2020-04-05 11:56:44	t
141	RNI	RDNI	Construção Civil	67.010.660/0001-24	\N	\N	\N	1.885	1.219	2020-04-05 11:56:44	t
142	Rede Energia	REDE	Petróleo, Gás e Biocombustíveis	61.584.140/0001-49	\N	\N	\N	21.127	7.309	2020-04-05 11:56:44	t
143	Localiza	RENT	Aluguel e Venda de Carros	16.670.085/0001-55	\N	\N	\N	27.861	12.189	2020-04-05 11:56:44	t
144	Cosan Logística	RLOG	Logística e Ferroviário	17.346.997/0001-39	\N	\N	\N	111.059	26.434	2020-04-05 11:56:44	t
279	Renova	RNEW	Energia	08.534.605/0001-74	\N	\N	\N	13.09	0.208	2020-04-05 11:56:44	t
145	Indústrias Romi	ROMI	Máquinas e Equipamentos	56.720.428/0001-63	\N	\N	\N	2.074	0.481	2020-04-05 11:56:44	t
280	Alfa Holdings	RPAD	Holding	17.167.396/0001-69	\N	\N	\N	0.963	0.796	2020-04-05 11:56:44	t
146	PET Manguinhos	RPMG	Petróleo, Gás e Biocombustíveis	33.412.081/0001-96	\N	\N	\N	3.886	2.22	2020-04-05 11:56:44	t
147	Rossi	RSID	Construção Civil	61.065.751/0001-80	\N	\N	\N	5.067	5.361	2020-04-05 11:56:44	t
281	Riosulense	RSUL	Metalurgia	85.778.074/0001-06	\N	\N	\N	0.345	0.026	2020-04-05 11:56:44	t
282	Santander	SANB	Bancos	90.400.888/0001-42	\N	\N	\N	316.466	18.507	2020-04-05 11:56:44	t
283	Sanepar	SAPR	Saneamento	76.484.013/0001-45	\N	\N	\N	17.161	6.653	2020-04-05 11:56:44	t
300	Usiminas	USIM	Siderurgia	60.894.730/0001-05	\N	\N	\N	40.208	9.86	2020-04-05 11:56:44	t
174	Vale	VALE	Mineração	33.592.510/0001-54	\N	\N	\N	574.496	27.678	2020-04-05 11:56:44	t
175	Viver	VIVR	Construção Civil	67.571.414/0001-41	\N	\N	\N	0.32	1.157	2020-04-05 11:56:44	t
301	Telefônica	VIVT	Telecomunicações	02.558.157/0001-62	\N	\N	\N	204.02	47.046	2020-04-05 11:56:44	t
176	Valid	VLID	Documentos de Segurança	33.113.309/0001-47	\N	\N	\N	6.541	1.773	2020-04-05 11:56:44	t
177	Vulcabras	VULC	Calçados	50.926.955/0001-42	\N	\N	\N	3.51	0.231	2020-04-05 11:56:44	t
178	Via Varejo	VVAR	Comércio Varejista	33.041.260/0652-90	\N	\N	\N	47.718	2.057	2020-04-05 11:56:44	t
179	Weg	WEGE	Motores e Compressores	84.429.695/0001-11	\N	\N	\N	35.22	8.374	2020-04-05 11:56:44	t
302	Whirlpool	WHRL	Eletrodomésticos	59.105.999/0001-86	\N	\N	\N	13.377	1.172	2020-04-05 11:56:44	t
180	WIZ Soluções	WIZS	Seguros	42.278.473/0001-03	\N	\N	\N	6.117	0.443	2020-04-05 11:56:44	t
303	WLM	WLMM	Automotivo e Agropecuário	33.228.024/0001-51	\N	\N	\N	1.339	0.263	2020-04-05 11:56:44	t
170	Tarpon	TRPN	Gestão de Recursos	05.341.549/0001-63	\N	\N	\N	0	0	\N	t
24	Banco do Nordeste	BNBR	Bancos	07.237.373/0001-20	\N	\N	\N	11.951	2.717	2020-04-05 11:56:43	t
194	Bombril	BOBR	Produtos de Limpeza	50.564.053/0001-03	\N	\N	\N	0.738	0.404	2020-04-05 11:56:43	t
195	Banco BTG Pactual	BPAC	Bancos	30.306.294/0001-45	\N	\N	\N	81.484	13.983	2020-04-05 11:56:43	t
196	Bradespar	BRAP	Holding	03.847.461/0001-92	\N	\N	\N	7.741	1.37	2020-04-05 11:56:43	t
27	BR Distribuidora	BRDT	Petróleo, Gás e Biocombustíveis	34.274.233/0001-02	\N	\N	\N	18.34	18.135	2020-04-05 11:56:43	t
28	BRF	BRFS	Carnes e Derivados	01.838.723/0001-27	\N	\N	\N	84.551	12.726	2020-04-05 11:56:43	t
197	Alfa Consórcio	BRGE	Seguros	17.193.806/0001-46	\N	\N	\N	3.044	0.91	2020-04-05 11:56:43	t
198	Banco Alfa	BRIV	Bancos	60.770.336/0001-65	\N	\N	\N	1.716	0.345	2020-04-05 11:56:43	t
199	Braskem	BRKM	Químicos	42.150.391/0001-70	\N	\N	\N	108.32	17.369	2020-04-05 11:56:43	t
95	Kepler	KEPL	Máquinas e Equipamentos	91.983.056/0001-69	\N	\N	\N	1.659	0.028	2020-04-05 11:56:44	t
255	Klabin	KLBN	Papel e Celulose	89.637.490/0001-45	\N	\N	\N	39.356	25.768	2020-04-05 11:56:44	t
256	Lojas Americanas	LAME	Comércio Varejista	33.014.556/0001-96	\N	\N	\N	48.057	27.621	2020-04-05 11:56:44	t
97	Locamérica	LCAM	Aluguel e Venda de Carros	10.215.988/0001-60	\N	\N	\N	26.331	8.033	2020-04-05 11:56:44	t
98	Mahle Metal Leve	LEVE	Peças para Motores	60.476.884/0001-87	\N	\N	\N	6.346	0.454	2020-04-05 11:56:44	t
99	Light	LIGT	Energia	03.378.521/0001-75	\N	\N	\N	12.642	7.597	2020-04-05 11:56:44	t
100	Linx	LINX	Software	06.948.969/0001-75	\N	\N	\N	9.173	2.279	2020-04-05 11:56:44	t
101	Eletropar	LIPR	Energia	01.104.937/0001-70	\N	\N	\N	1.576	0.143	2020-04-05 11:56:44	t
102	Liq	LIQO	Consultoria	04.032.433/0001-80	\N	\N	\N	3.248	1.446	2020-04-05 11:56:44	t
103	Le Lis Blanc	LLIS	Vestuário	49.669.856/0001-43	\N	\N	\N	10.581	3.705	2020-04-05 11:56:44	t
104	Log CP	LOGG	Construção Civil	09.041.168/0001-10	\N	\N	\N	9.687	1.882	2020-04-05 11:56:44	t
307	Amazon	AMZN	Specialty Retail	911646860	\N	\N	\N	\N	\N	\N	t
308	Visa	V	Credit Services	260267673	\N	\N	\N	\N	\N	\N	t
309	Alphabet(Google)	GOOGL	Internet Content & Information	611767919	\N	\N	\N	\N	\N	\N	t
310	Microsoft	MSFT	Software - Infrastructure	911144442	\N	\N	\N	\N	\N	\N	t
311	Accenture	ACN	Information Technology Services	980627530	\N	\N	\N	\N	\N	\N	t
312	Novo Nordisk	NVO	Biotechnology	16.921.603/0001	\N	\N	\N	\N	\N	\N	t
\.


--
-- Data for Name: ativo; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.ativo (id, nome, codigo, acao_bolsa_id, categoria, tipo, pais, classe_atualiza_id) FROM stdin;
13	ALASKA BLACK FIC FIA II	ALASKA BLACK FIC FIA II	\N	Renda Variável	Fundos de Investimentos	BR	1
15	Itausa	ITSA4	\N	Renda Variável	Ações	BR	1
24	M.Dias Branco	MDIA3	109	Renda Variável	Ações	BR	1
25	Odonto Prev	ODPV3	125	Renda Variável	Ações	BR	1
38	CSHG Logística	HGLG11	\N	Renda Variável	FIIs	BR	1
39	XP Logística	XPLG11	\N	Renda Variável	FIIs	BR	1
40	XP Malls	XPML11	\N	Renda Variável	FIIs	BR	1
42	Fator Verita	VRTA11	\N	Renda Variável	FIIs	BR	1
31	Visa	V	308	Renda Variável	Ações	US	1
14	Banco inter	BIDI4	20	Renda Variável	Ações	BR	1
20	fleury	FLRY3	69	Renda Variável	Ações	BR	1
16	Itausa	ITSA3	251	Renda Variável	Ações	BR	1
21	weg	WEGE3	179	Renda Variável	Ações	BR	1
17	ambev	ABEV3	3	Renda Variável	Ações	BR	1
18	B3	B3SA3	13	Renda Variável	Ações	BR	1
19	engie	EGIE3	57	Renda Variável	Ações	BR	1
23	Grendene	GRND3	78	Renda Variável	Ações	BR	1
29	Amazon	AMZN	307	Renda Variável	Ações	US	1
30	Google	GOOGL	309	Renda Variável	Ações	US	1
32	Microsoft	MSFT	310	Renda Variável	Ações	US	1
34	Accenture	ACN	311	Renda Variável	Ações	US	1
35	Novo Nordisk	NVO	312	Renda Variável	Ações	US	1
37	BlackRock Institutional Trust Company N.A. - BTC iShares Gold Trust	IAU	\N	Renda Variável	Ouro	US	1
49	TG Ativo Real	TGAR11	\N	Renda Variável	FIIs	BR	1
50	Meta Platforms	FB	\N	Renda Variável	Ações	US	1
51	Bitcoin	BTC	\N	Renda Variável	Criptomoeda	BR	1
53	Kilima Suno 30	KISU11	\N	Renda Variável	FIIs	BR	1
54	Prologis Inc	PLD	\N	Renda Variável	Ações	US	1
55	REALTY INCOME CORP 	O	\N	Renda Variável	Ações	US	1
33	Cdb banco inter liquides diário	CDB_BANCO_INTER_LIQ_DIARIA	\N	Renda Fixa	CDB	BR	2
56	Dollar	DOLLAR	\N	Renda Variável	Dollar	US	1
57	Tesouro Selic 2019	Tesouro Selic 2029-SELIC-01/03/2029	\N	Renda Fixa	Tesouro Direto	BR	3
36	Tesouro IPCA+ 2026 - 15/08/2026	Tesouro IPCA+ 2026-IPCA-15/08/2026	\N	Renda Fixa	Tesouro Direto	BR	3
41	Tesouro-Selic-2027-SELIC+0,3183	Tesouro-Selic-2027-SELIC+0,3183	\N	Renda Fixa	Tesouro Direto	BR	3
5	BANCO AGIBANK - 121.50% - 20/04/2020	BANCO AGIBANK-121,50% do CDI-20/04/2020	\N	Renda Fixa	CDB	BR	3
4	Tesouro Selic 2025	Tesouro Selic 2025-SELIC-01/03/2025	\N	Renda Fixa	Tesouro Direto	BR	3
1	Tesouro Selic 2023	Tesouro Selic 2023-SELIC-01/03/2023	\N	Renda Fixa	Tesouro Direto	BR	3
7	CMDT23 - CEMIG DISTRIBUICAO S.A-IPC-A + 9,70%-15/02/2021	CMDT23 - CEMIG DISTRIBUICAO S.A-IPC-A + 9,70%-15/02/2021	\N	Renda Fixa	Debêntures	BR	3
2	CMDT23 - CEMIG DISTRIBUICAO S.A  IPC-A + 9.15%	CMDT23 - CEMIG DISTRIBUICAO S.A-IPC-A + 9,15%-15/02/2021	\N	Renda Fixa	Debêntures	BR	3
26	Tesouro ipca 2035	Tesouro IPCA+ 2035-IPCA-15/05/2035	\N	Renda Fixa	Tesouro Direto	BR	3
9	Banco Maxima - 121% CDI	BANCO MASTER-121% do CDI-30/01/2023	\N	Renda Fixa	CDB	BR	3
10	Banco Maxima - 128% CDI - 21/07/2023	BANCO MASTER-128% do CDI-21/07/2023	\N	Renda Fixa	CDB	BR	3
11	Banco Maxima - 128% CDI - 28/01/2026	BANCO MASTER-128% do CDI-28/01/2026	\N	Renda Fixa	CDB	BR	3
3	Tesouro IPCA+ 2024	Tesouro IPCA+ 2024-IPCA-15/08/2024	\N	Renda Fixa	Tesouro Direto	BR	3
52	Tesouro Selic 2027-SELIC +  0,1640  -01/03/2027	Tesouro Selic 2027-SELIC-01/03/2027	\N	Renda Fixa	Tesouro Direto	BR	3
\.


--
-- Data for Name: atualiza_acoes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.atualiza_acoes (id, data, ativo_atualizado, status) FROM stdin;
\.


--
-- Data for Name: atualiza_ativo_manual; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.atualiza_ativo_manual (id, itens_ativo_id) FROM stdin;
1	40
\.


--
-- Data for Name: atualiza_nu; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.atualiza_nu (id, valor_bruto_antigo, valor_liquido_antigo, operacoes_import_id, itens_ativo_id) FROM stdin;
1	1313.88	1313.88	130	20
2	12660.88	12660.88	130	21
3	1067.19	1067.19	130	22
4	32440.57	32440.57	130	47
5	6952.45	6952.45	130	53
\.


--
-- Data for Name: atualiza_operacoes_manual; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.atualiza_operacoes_manual (id, valor_bruto, valor_liquido, atualiza_ativo_manual_id, data) FROM stdin;
1	22223.10	21704.82	1	2023-02-06 20:30:55
2	20270.46	19774.39	1	2023-03-07 18:35:18
3	19406.43	18928.01	1	2023-03-14 18:10:46
4	18205.01	17748.57	1	2023-03-26 17:40:19
\.


--
-- Data for Name: auditoria; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.auditoria (id, model, operacao, changes, user_id, created_at) FROM stdin;
10143	app\\models\\financas\\ItensAtivo	update	{"id": 22, "ativo": true, "ativo_id": 36, "quantidade": 0.33, "valor_bruto": "1068.21", "valor_compra": 984.95, "investidor_id": 1, "valor_liquido": 984.95}	2	1687099025
10144	app\\models\\financas\\ItensAtivo	update	{"id": 48, "ativo": true, "ativo_id": 53, "quantidade": 317, "valor_bruto": "2428.6", "valor_compra": 2565.677596439169, "investidor_id": 1, "valor_liquido": 2565.677596439169}	2	1687099025
10145	app\\models\\financas\\ItensAtivo	update	{"id": 47, "ativo": true, "ativo_id": 52, "quantidade": 2.8000000000000003, "valor_bruto": "35593.75", "valor_compra": 32934.780000000006, "investidor_id": 1, "valor_liquido": 32934.780000000006}	2	1687099025
10146	app\\models\\financas\\ItensAtivo	update	{"id": 55, "ativo": true, "ativo_id": 57, "quantidade": 0.08, "valor_bruto": "1033.09", "valor_compra": 1033.09, "investidor_id": 2, "valor_liquido": 1033.09}	2	1687099025
10147	app\\models\\financas\\ItensAtivo	update	{"id": 52, "ativo": true, "ativo_id": 55, "quantidade": 28.52771, "valor_bruto": "1788.4021399", "valor_compra": 1912.6799999999998, "investidor_id": 1, "valor_liquido": 1912.6799999999998}	2	1687099025
10148	app\\models\\financas\\ItensAtivo	update	{"id": 53, "ativo": true, "ativo_id": 57, "quantidade": 0.71, "valor_bruto": "7992.3", "valor_compra": 9008.13, "investidor_id": 1, "valor_liquido": 9008.13}	2	1687099025
10149	app\\models\\financas\\ItensAtivo	update	{"id": 54, "ativo": true, "ativo_id": 52, "quantidade": 0.08, "valor_bruto": "1012.86", "valor_compra": 1012.86, "investidor_id": 2, "valor_liquido": 1012.86}	2	1687099025
10150	app\\models\\financas\\ItensAtivo	update	{"id": 23, "ativo": true, "ativo_id": 41, "quantidade": 0.7299999999999999, "valor_bruto": "8385.16", "valor_compra": 8385.16, "investidor_id": 2, "valor_liquido": 8385.16}	2	1687099025
10151	app\\models\\financas\\ItensAtivo	update	{"id": 35, "ativo": true, "ativo_id": 34, "quantidade": 8.75256, "valor_bruto": "2411.7679080", "valor_compra": 2342.8399999999997, "investidor_id": 1, "valor_liquido": 2342.8399999999997}	2	1687099025
10152	app\\models\\financas\\ItensAtivo	update	{"id": 36, "ativo": true, "ativo_id": 35, "quantidade": 21.396400000000003, "valor_bruto": "3578.975828", "valor_compra": 1517.678203181342, "investidor_id": 1, "valor_liquido": 1517.678203181342}	2	1687099025
10153	app\\models\\financas\\ItensAtivo	update	{"id": 42, "ativo": true, "ativo_id": 35, "quantidade": 1.61888, "valor_bruto": "270.7900576", "valor_compra": 171.02, "investidor_id": 2, "valor_liquido": 171.02}	2	1687099025
10154	app\\models\\financas\\ItensAtivo	update	{"id": 38, "ativo": true, "ativo_id": 37, "quantidade": 10.82491, "valor_bruto": "408.4238543", "valor_compra": 373, "investidor_id": 2, "valor_liquido": 373}	2	1687099025
10155	app\\models\\financas\\ItensAtivo	update	{"id": 37, "ativo": true, "ativo_id": 37, "quantidade": 70.21576000000002, "valor_bruto": "2649.2406248", "valor_compra": 2387.24, "investidor_id": 1, "valor_liquido": 2387.24}	2	1687099025
10156	app\\models\\financas\\ItensAtivo	update	{"id": 43, "ativo": true, "ativo_id": 49, "quantidade": 129, "valor_bruto": "14490.57", "valor_compra": 15093.679979999995, "investidor_id": 1, "valor_liquido": 15093.679979999995}	2	1687099025
10157	app\\models\\financas\\ItensAtivo	update	{"id": 32, "ativo": true, "ativo_id": 29, "quantidade": 17.2086, "valor_bruto": "1816.711902", "valor_compra": 2783.3500000000004, "investidor_id": 1, "valor_liquido": 2783.3500000000004}	2	1687099025
10158	app\\models\\financas\\ItensAtivo	update	{"id": 45, "ativo": true, "ativo_id": 29, "quantidade": 1.339, "valor_bruto": "141.35823", "valor_compra": 195.19, "investidor_id": 2, "valor_liquido": 195.19}	2	1687099025
10159	app\\models\\financas\\ItensAtivo	update	{"id": 39, "ativo": true, "ativo_id": 32, "quantidade": 1.3328600000000002, "valor_bruto": "406.7622148", "valor_compra": 365.53999999999996, "investidor_id": 2, "valor_liquido": 365.53999999999996}	2	1687099025
10160	app\\models\\financas\\ItensAtivo	update	{"id": 34, "ativo": true, "ativo_id": 32, "quantidade": 10.22714, "valor_bruto": "3121.1185852", "valor_compra": 2434.7699999999995, "investidor_id": 1, "valor_liquido": 2434.7699999999995}	2	1687099025
10161	app\\models\\financas\\ItensAtivo	update	{"id": 25, "ativo": true, "ativo_id": 20, "quantidade": 174, "valor_bruto": "2510.82", "valor_compra": 4350.53, "investidor_id": 1, "valor_liquido": 4350.53}	2	1687099025
10162	app\\models\\financas\\ItensAtivo	update	{"id": 14, "ativo": true, "ativo_id": 39, "quantidade": 11, "valor_bruto": "1124.31", "valor_compra": 1053.18, "investidor_id": 2, "valor_liquido": 1053.18}	2	1687099025
10163	app\\models\\financas\\ItensAtivo	update	{"id": 17, "ativo": true, "ativo_id": 40, "quantidade": 10, "valor_bruto": "1030.80", "valor_compra": 1022, "investidor_id": 2, "valor_liquido": 1022}	2	1687099025
10164	app\\models\\financas\\ItensAtivo	update	{"id": 41, "ativo": true, "ativo_id": 30, "quantidade": 2.9489300000000003, "valor_bruto": "315.2111277", "valor_compra": 376.96000000000004, "investidor_id": 2, "valor_liquido": 376.96000000000004}	2	1687099025
10165	app\\models\\financas\\ItensAtivo	update	{"id": 29, "ativo": true, "ativo_id": 18, "quantidade": 306, "valor_bruto": "3552.66", "valor_compra": 5180.159999999999, "investidor_id": 1, "valor_liquido": 5180.159999999999}	2	1687099025
10166	app\\models\\financas\\ItensAtivo	update	{"id": 44, "ativo": true, "ativo_id": 50, "quantidade": 1.35168, "valor_bruto": "320.0643072", "valor_compra": 277, "investidor_id": 1, "valor_liquido": 277}	2	1687099025
10167	app\\models\\financas\\ItensAtivo	update	{"id": 33, "ativo": true, "ativo_id": 30, "quantidade": 21.2842, "valor_bruto": "2275.068138", "valor_compra": 2111.97, "investidor_id": 1, "valor_liquido": 2111.97}	2	1687099025
10168	app\\models\\financas\\ItensAtivo	update	{"id": 8, "ativo": true, "ativo_id": 24, "quantidade": 66, "valor_bruto": "1875.72", "valor_compra": 2137.349577464789, "investidor_id": 1, "valor_liquido": 2137.349577464789}	2	1687099025
10169	app\\models\\financas\\ItensAtivo	update	{"id": 30, "ativo": true, "ativo_id": 19, "quantidade": 85, "valor_bruto": "3485.85", "valor_compra": 3712.14144144144, "investidor_id": 1, "valor_liquido": 3712.14144144144}	2	1687099025
10170	app\\models\\financas\\ItensAtivo	update	{"id": 28, "ativo": true, "ativo_id": 17, "quantidade": 288, "valor_bruto": "4066.56", "valor_compra": 4473.49, "investidor_id": 1, "valor_liquido": 4473.49}	2	1687099025
10171	app\\models\\financas\\ItensAtivo	update	{"id": 9, "ativo": true, "ativo_id": 25, "quantidade": 253, "valor_bruto": "2532.53", "valor_compra": 3667.1575510204075, "investidor_id": 1, "valor_liquido": 3667.1575510204075}	2	1687099025
10172	app\\models\\financas\\ItensAtivo	update	{"id": 31, "ativo": true, "ativo_id": 23, "quantidade": 616, "valor_bruto": "5001.92", "valor_compra": 4831.209999999999, "investidor_id": 1, "valor_liquido": 4831.209999999999}	2	1687099025
10173	app\\models\\financas\\ItensAtivo	update	{"id": 26, "ativo": true, "ativo_id": 16, "quantidade": 427, "valor_bruto": "3744.79", "valor_compra": 5110.2303999999995, "investidor_id": 1, "valor_liquido": 5110.2303999999995}	2	1687099025
10174	app\\models\\financas\\ItensAtivo	update	{"id": 13, "ativo": true, "ativo_id": 42, "quantidade": 174, "valor_bruto": "14414.16", "valor_compra": 18020.090099999998, "investidor_id": 1, "valor_liquido": 18020.090099999998}	2	1687099025
10175	app\\models\\financas\\ItensAtivo	update	{"id": 10, "ativo": true, "ativo_id": 38, "quantidade": 48, "valor_bruto": "7799.52", "valor_compra": 8095.378039215686, "investidor_id": 1, "valor_liquido": 8095.378039215686}	2	1687099025
10176	app\\models\\financas\\ItensAtivo	update	{"id": 46, "ativo": true, "ativo_id": 51, "quantidade": 0.01867941, "valor_bruto": "2753.04616344", "valor_compra": 2187, "investidor_id": 1, "valor_liquido": 2187}	2	1687099025
10177	app\\models\\financas\\ItensAtivo	update	{"id": 51, "ativo": true, "ativo_id": 54, "quantidade": 1.61444, "valor_bruto": "200.9170580", "valor_compra": 181.78, "investidor_id": 2, "valor_liquido": 181.78}	2	1687099025
10178	app\\models\\financas\\ItensAtivo	update	{"id": 49, "ativo": true, "ativo_id": 54, "quantidade": 16.726, "valor_bruto": "2081.55070", "valor_compra": 2006.81, "investidor_id": 1, "valor_liquido": 2006.81}	2	1687099025
10179	app\\models\\financas\\ItensAtivo	update	{"id": 50, "ativo": true, "ativo_id": 55, "quantidade": 6.13338, "valor_bruto": "384.5015922", "valor_compra": 380.8, "investidor_id": 2, "valor_liquido": 380.8}	2	1687099025
10180	app\\models\\financas\\ItensAtivo	update	{"id": 40, "ativo": true, "ativo_id": 33, "quantidade": 200.19100000000006, "valor_bruto": "18205.01", "valor_compra": 63814.1396576398, "investidor_id": 1, "valor_liquido": 63814.1396576398}	2	1687099025
10181	app\\models\\financas\\ItensAtivo	update	{"id": 20, "ativo": true, "ativo_id": 11, "quantidade": 1, "valor_bruto": "1372.36", "valor_compra": 1000, "investidor_id": 1, "valor_liquido": 1000}	2	1687099025
10182	app\\models\\financas\\ItensAtivo	update	{"id": 27, "ativo": true, "ativo_id": 21, "quantidade": 71, "valor_bruto": "2904.61", "valor_compra": 1509.9557966101697, "investidor_id": 1, "valor_liquido": 1509.9557966101697}	2	1687099025
10183	app\\models\\financas\\ItensAtivo	update	{"id": 21, "ativo": true, "ativo_id": 3, "quantidade": 3.54, "valor_bruto": "12899.76", "valor_compra": 7963.17, "investidor_id": 1, "valor_liquido": 7963.17}	2	1687099025
10184	app\\models\\financas\\ItensAtivo	update	{"id": 12, "ativo": true, "ativo_id": 40, "quantidade": 69, "valor_bruto": "7112.52", "valor_compra": 7105.83443139785, "investidor_id": 1, "valor_liquido": 7105.83443139785}	2	1687099025
10185	app\\models\\financas\\ItensAtivo	update	{"id": 11, "ativo": true, "ativo_id": 39, "quantidade": 80, "valor_bruto": "8176.80", "valor_compra": 8406.587307692309, "investidor_id": 1, "valor_liquido": 8406.587307692309}	2	1687099025
10186	app\\models\\financas\\Ativo	update	{"id": 57, "nome": "Tesouro Selic 2019", "pais": "BR", "tipo": "Tesouro Direto", "codigo": "Tesouro Selic 2029-SELIC-01/03/2029", "categoria": "Renda Fixa", "acao_bolsa_id": null, "classe_atualiza_id": 3}	2	1687100001
10187	app\\models\\financas\\Ativo	update	{"id": 36, "nome": "Tesouro IPCA+ 2026 - 15/08/2026", "pais": "BR", "tipo": "Tesouro Direto", "codigo": "Tesouro IPCA+ 2026-IPCA-15/08/2026", "categoria": "Renda Fixa", "acao_bolsa_id": null, "classe_atualiza_id": 3}	2	1687100001
10188	app\\models\\financas\\Ativo	update	{"id": 41, "nome": "Tesouro-Selic-2027-SELIC+0,3183", "pais": "BR", "tipo": "Tesouro Direto", "codigo": "Tesouro-Selic-2027-SELIC+0,3183", "categoria": "Renda Fixa", "acao_bolsa_id": null, "classe_atualiza_id": 3}	2	1687100001
10189	app\\models\\financas\\Ativo	update	{"id": 5, "nome": "BANCO AGIBANK - 121.50% - 20/04/2020", "pais": "BR", "tipo": "CDB", "codigo": "BANCO AGIBANK-121,50% do CDI-20/04/2020", "categoria": "Renda Fixa", "acao_bolsa_id": null, "classe_atualiza_id": 3}	2	1687100001
10190	app\\models\\financas\\Ativo	update	{"id": 4, "nome": "Tesouro Selic 2025", "pais": "BR", "tipo": "Tesouro Direto", "codigo": "Tesouro Selic 2025-SELIC-01/03/2025", "categoria": "Renda Fixa", "acao_bolsa_id": null, "classe_atualiza_id": 3}	2	1687100001
10191	app\\models\\financas\\Ativo	update	{"id": 1, "nome": "Tesouro Selic 2023", "pais": "BR", "tipo": "Tesouro Direto", "codigo": "Tesouro Selic 2023-SELIC-01/03/2023", "categoria": "Renda Fixa", "acao_bolsa_id": null, "classe_atualiza_id": 3}	2	1687100001
10192	app\\models\\financas\\Ativo	update	{"id": 7, "nome": "CMDT23 - CEMIG DISTRIBUICAO S.A-IPC-A + 9,70%-15/02/2021", "pais": "BR", "tipo": "Debêntures", "codigo": "CMDT23 - CEMIG DISTRIBUICAO S.A-IPC-A + 9,70%-15/02/2021", "categoria": "Renda Fixa", "acao_bolsa_id": null, "classe_atualiza_id": 3}	2	1687100001
10193	app\\models\\financas\\Ativo	update	{"id": 2, "nome": "CMDT23 - CEMIG DISTRIBUICAO S.A  IPC-A + 9.15%", "pais": "BR", "tipo": "Debêntures", "codigo": "CMDT23 - CEMIG DISTRIBUICAO S.A-IPC-A + 9,15%-15/02/2021", "categoria": "Renda Fixa", "acao_bolsa_id": null, "classe_atualiza_id": 3}	2	1687100001
10194	app\\models\\financas\\Ativo	update	{"id": 26, "nome": "Tesouro ipca 2035", "pais": "BR", "tipo": "Tesouro Direto", "codigo": "Tesouro IPCA+ 2035-IPCA-15/05/2035", "categoria": "Renda Fixa", "acao_bolsa_id": null, "classe_atualiza_id": 3}	2	1687100001
10195	app\\models\\financas\\Ativo	update	{"id": 9, "nome": "Banco Maxima - 121% CDI", "pais": "BR", "tipo": "CDB", "codigo": "BANCO MASTER-121% do CDI-30/01/2023", "categoria": "Renda Fixa", "acao_bolsa_id": null, "classe_atualiza_id": 3}	2	1687100001
10196	app\\models\\financas\\Ativo	update	{"id": 10, "nome": "Banco Maxima - 128% CDI - 21/07/2023", "pais": "BR", "tipo": "CDB", "codigo": "BANCO MASTER-128% do CDI-21/07/2023", "categoria": "Renda Fixa", "acao_bolsa_id": null, "classe_atualiza_id": 3}	2	1687100001
10197	app\\models\\financas\\Ativo	update	{"id": 11, "nome": "Banco Maxima - 128% CDI - 28/01/2026", "pais": "BR", "tipo": "CDB", "codigo": "BANCO MASTER-128% do CDI-28/01/2026", "categoria": "Renda Fixa", "acao_bolsa_id": null, "classe_atualiza_id": 3}	2	1687100001
10198	app\\models\\financas\\Ativo	update	{"id": 3, "nome": "Tesouro IPCA+ 2024", "pais": "BR", "tipo": "Tesouro Direto", "codigo": "Tesouro IPCA+ 2024-IPCA-15/08/2024", "categoria": "Renda Fixa", "acao_bolsa_id": null, "classe_atualiza_id": 3}	2	1687100001
10199	app\\models\\financas\\Ativo	update	{"id": 52, "nome": "Tesouro Selic 2027-SELIC +  0,1640  -01/03/2027", "pais": "BR", "tipo": "Tesouro Direto", "codigo": "Tesouro Selic 2027-SELIC-01/03/2027", "categoria": "Renda Fixa", "acao_bolsa_id": null, "classe_atualiza_id": 3}	2	1687100001
10200	app\\models\\financas\\ItensAtivo	update	{"id": 26, "ativo": true, "ativo_id": 16, "quantidade": "427", "valor_bruto": "3744.79", "valor_compra": "5110.2304", "investidor_id": 1, "valor_liquido": "3744.79"}	2	1687100025
10201	app\\models\\financas\\ItensAtivo	update	{"id": 28, "ativo": true, "ativo_id": 17, "quantidade": "288", "valor_bruto": "4066.56", "valor_compra": "4473.49", "investidor_id": 1, "valor_liquido": "4066.56"}	2	1687100025
10202	app\\models\\financas\\ItensAtivo	update	{"id": 29, "ativo": true, "ativo_id": 18, "quantidade": "306", "valor_bruto": "3552.66", "valor_compra": "5180.16", "investidor_id": 1, "valor_liquido": "3552.66"}	2	1687100025
10203	app\\models\\financas\\ItensAtivo	update	{"id": 30, "ativo": true, "ativo_id": 19, "quantidade": "85", "valor_bruto": "3485.85", "valor_compra": "3712.1414414414", "investidor_id": 1, "valor_liquido": "3485.85"}	2	1687100025
10204	app\\models\\financas\\ItensAtivo	update	{"id": 25, "ativo": true, "ativo_id": 20, "quantidade": "174", "valor_bruto": "2510.82", "valor_compra": "4350.53", "investidor_id": 1, "valor_liquido": "2510.82"}	2	1687100025
10205	app\\models\\financas\\ItensAtivo	update	{"id": 27, "ativo": true, "ativo_id": 21, "quantidade": "71", "valor_bruto": "2904.61", "valor_compra": "1509.9557966102", "investidor_id": 1, "valor_liquido": "2904.61"}	2	1687100025
10206	app\\models\\financas\\ItensAtivo	update	{"id": 31, "ativo": true, "ativo_id": 23, "quantidade": "616", "valor_bruto": "5001.92", "valor_compra": "4831.21", "investidor_id": 1, "valor_liquido": "5001.92"}	2	1687100025
10207	app\\models\\financas\\ItensAtivo	update	{"id": 8, "ativo": true, "ativo_id": 24, "quantidade": "66", "valor_bruto": "1875.72", "valor_compra": "2137.3495774648", "investidor_id": 1, "valor_liquido": "1875.72"}	2	1687100025
10208	app\\models\\financas\\ItensAtivo	update	{"id": 9, "ativo": true, "ativo_id": 25, "quantidade": "253", "valor_bruto": "2532.53", "valor_compra": "3667.1575510204", "investidor_id": 1, "valor_liquido": "2532.53"}	2	1687100025
10209	app\\models\\financas\\ItensAtivo	update	{"id": 45, "ativo": true, "ativo_id": 29, "quantidade": "1.339", "valor_bruto": "141.35823", "valor_compra": "195.19", "investidor_id": 2, "valor_liquido": "141.35823"}	2	1687100025
10210	app\\models\\financas\\ItensAtivo	update	{"id": 32, "ativo": true, "ativo_id": 29, "quantidade": "17.2086", "valor_bruto": "1816.711902", "valor_compra": "2783.35", "investidor_id": 1, "valor_liquido": "1816.711902"}	2	1687100025
10211	app\\models\\financas\\ItensAtivo	update	{"id": 33, "ativo": true, "ativo_id": 30, "quantidade": "21.2842", "valor_bruto": "2275.068138", "valor_compra": "2111.97", "investidor_id": 1, "valor_liquido": "2275.068138"}	2	1687100025
10212	app\\models\\financas\\ItensAtivo	update	{"id": 41, "ativo": true, "ativo_id": 30, "quantidade": "2.94893", "valor_bruto": "315.2111277", "valor_compra": "376.96", "investidor_id": 2, "valor_liquido": "315.2111277"}	2	1687100025
10213	app\\models\\financas\\ItensAtivo	update	{"id": 34, "ativo": true, "ativo_id": 32, "quantidade": "10.22714", "valor_bruto": "3121.1185852", "valor_compra": "2434.77", "investidor_id": 1, "valor_liquido": "3121.1185852"}	2	1687100025
10214	app\\models\\financas\\ItensAtivo	update	{"id": 39, "ativo": true, "ativo_id": 32, "quantidade": "1.33286", "valor_bruto": "406.7622148", "valor_compra": "365.54", "investidor_id": 2, "valor_liquido": "406.7622148"}	2	1687100025
10215	app\\models\\financas\\ItensAtivo	update	{"id": 35, "ativo": true, "ativo_id": 34, "quantidade": "8.75256", "valor_bruto": "2411.7679080", "valor_compra": "2342.84", "investidor_id": 1, "valor_liquido": "2411.7679080"}	2	1687100025
10216	app\\models\\financas\\ItensAtivo	update	{"id": 42, "ativo": true, "ativo_id": 35, "quantidade": "1.61888", "valor_bruto": "270.7900576", "valor_compra": "171.02", "investidor_id": 2, "valor_liquido": "270.7900576"}	2	1687100025
10217	app\\models\\financas\\ItensAtivo	update	{"id": 36, "ativo": true, "ativo_id": 35, "quantidade": "21.3964", "valor_bruto": "3578.975828", "valor_compra": "1517.6782031813", "investidor_id": 1, "valor_liquido": "3578.975828"}	2	1687100025
10218	app\\models\\financas\\ItensAtivo	update	{"id": 37, "ativo": true, "ativo_id": 37, "quantidade": "70.21576", "valor_bruto": "2649.2406248", "valor_compra": "2387.24", "investidor_id": 1, "valor_liquido": "2649.2406248"}	2	1687100025
10219	app\\models\\financas\\ItensAtivo	update	{"id": 38, "ativo": true, "ativo_id": 37, "quantidade": "10.82491", "valor_bruto": "408.4238543", "valor_compra": "373", "investidor_id": 2, "valor_liquido": "408.4238543"}	2	1687100025
10220	app\\models\\financas\\ItensAtivo	update	{"id": 10, "ativo": true, "ativo_id": 38, "quantidade": "48", "valor_bruto": "7799.52", "valor_compra": "8095.3780392157", "investidor_id": 1, "valor_liquido": "7799.52"}	2	1687100026
10221	app\\models\\financas\\ItensAtivo	update	{"id": 11, "ativo": true, "ativo_id": 39, "quantidade": "80", "valor_bruto": "8176.80", "valor_compra": "8406.5873076923", "investidor_id": 1, "valor_liquido": "8176.80"}	2	1687100026
10222	app\\models\\financas\\ItensAtivo	update	{"id": 14, "ativo": true, "ativo_id": 39, "quantidade": "11", "valor_bruto": "1124.31", "valor_compra": "1053.18", "investidor_id": 2, "valor_liquido": "1124.31"}	2	1687100026
10556	app\\models\\financas\\Operacao	insert	{"id": 836, "data": "2023-06-25 12:10:56", "tipo": "1", "valor": "10000", "quantidade": "100", "itens_ativos_id": "14"}	2	1687705976
10223	app\\models\\financas\\ItensAtivo	update	{"id": 12, "ativo": true, "ativo_id": 40, "quantidade": "69", "valor_bruto": "7112.52", "valor_compra": "7105.8344313978", "investidor_id": 1, "valor_liquido": "7112.52"}	2	1687100026
10224	app\\models\\financas\\ItensAtivo	update	{"id": 17, "ativo": true, "ativo_id": 40, "quantidade": "10", "valor_bruto": "1030.80", "valor_compra": "1022", "investidor_id": 2, "valor_liquido": "1030.80"}	2	1687100026
10225	app\\models\\financas\\ItensAtivo	update	{"id": 13, "ativo": true, "ativo_id": 42, "quantidade": "174", "valor_bruto": "14414.16", "valor_compra": "18020.0901", "investidor_id": 1, "valor_liquido": "14414.16"}	2	1687100026
10226	app\\models\\financas\\ItensAtivo	update	{"id": 43, "ativo": true, "ativo_id": 49, "quantidade": "129", "valor_bruto": "14490.57", "valor_compra": "15093.67998", "investidor_id": 1, "valor_liquido": "14490.57"}	2	1687100026
10227	app\\models\\financas\\ItensAtivo	update	{"id": 44, "ativo": true, "ativo_id": 50, "quantidade": "1.35168", "valor_bruto": "320.0643072", "valor_compra": "277", "investidor_id": 1, "valor_liquido": "320.0643072"}	2	1687100026
10228	app\\models\\financas\\ItensAtivo	update	{"id": 46, "ativo": true, "ativo_id": 51, "quantidade": "0.01867941", "valor_bruto": "2753.04616344", "valor_compra": "2187", "investidor_id": 1, "valor_liquido": "2753.04616344"}	2	1687100026
10229	app\\models\\financas\\ItensAtivo	update	{"id": 48, "ativo": true, "ativo_id": 53, "quantidade": "317", "valor_bruto": "2472.60", "valor_compra": "2565.6775964392", "investidor_id": 1, "valor_liquido": "2472.60"}	2	1687100026
10230	app\\models\\financas\\ItensAtivo	update	{"id": 49, "ativo": true, "ativo_id": 54, "quantidade": "16.726", "valor_bruto": "2081.55070", "valor_compra": "2006.81", "investidor_id": 1, "valor_liquido": "2081.55070"}	2	1687100026
10231	app\\models\\financas\\ItensAtivo	update	{"id": 51, "ativo": true, "ativo_id": 54, "quantidade": "1.61444", "valor_bruto": "200.9170580", "valor_compra": "181.78", "investidor_id": 2, "valor_liquido": "200.9170580"}	2	1687100026
10232	app\\models\\financas\\ItensAtivo	update	{"id": 50, "ativo": true, "ativo_id": 55, "quantidade": "6.13338", "valor_bruto": "384.5015922", "valor_compra": "380.8", "investidor_id": 2, "valor_liquido": "384.5015922"}	2	1687100026
10233	app\\models\\financas\\ItensAtivo	update	{"id": 52, "ativo": true, "ativo_id": 55, "quantidade": "28.52771", "valor_bruto": "1788.4021399", "valor_compra": "1912.68", "investidor_id": 1, "valor_liquido": "1788.4021399"}	2	1687100026
10234	app\\models\\financas\\ItensAtivo	update	{"id": 22, "ativo": true, "ativo_id": 36, "quantidade": 0.33, "valor_bruto": "1068.21", "valor_compra": 984.95, "investidor_id": 1, "valor_liquido": 984.95}	2	1687561447
10235	app\\models\\financas\\ItensAtivo	update	{"id": 47, "ativo": true, "ativo_id": 52, "quantidade": 2.8000000000000003, "valor_bruto": "35593.75", "valor_compra": 32934.780000000006, "investidor_id": 1, "valor_liquido": 32934.780000000006}	2	1687561447
10236	app\\models\\financas\\ItensAtivo	update	{"id": 55, "ativo": true, "ativo_id": 57, "quantidade": 0.08, "valor_bruto": "1033.09", "valor_compra": 1033.09, "investidor_id": 2, "valor_liquido": 1033.09}	2	1687561447
10237	app\\models\\financas\\ItensAtivo	update	{"id": 53, "ativo": true, "ativo_id": 57, "quantidade": 0.71, "valor_bruto": "7992.3", "valor_compra": 9008.13, "investidor_id": 1, "valor_liquido": 9008.13}	2	1687561447
10238	app\\models\\financas\\ItensAtivo	update	{"id": 54, "ativo": true, "ativo_id": 52, "quantidade": 0.08, "valor_bruto": "1012.86", "valor_compra": 1012.86, "investidor_id": 2, "valor_liquido": 1012.86}	2	1687561447
10239	app\\models\\financas\\ItensAtivo	update	{"id": 23, "ativo": true, "ativo_id": 41, "quantidade": 0.7299999999999999, "valor_bruto": "8385.16", "valor_compra": 8385.16, "investidor_id": 2, "valor_liquido": 8385.16}	2	1687561447
10240	app\\models\\financas\\ItensAtivo	update	{"id": 27, "ativo": true, "ativo_id": 21, "quantidade": 71, "valor_bruto": "2904.61", "valor_compra": 1509.9557966101697, "investidor_id": 1, "valor_liquido": 1509.9557966101697}	2	1687561447
10241	app\\models\\financas\\ItensAtivo	update	{"id": 31, "ativo": true, "ativo_id": 23, "quantidade": 616, "valor_bruto": "5001.92", "valor_compra": 4831.209999999999, "investidor_id": 1, "valor_liquido": 4831.209999999999}	2	1687561447
10242	app\\models\\financas\\ItensAtivo	update	{"id": 8, "ativo": true, "ativo_id": 24, "quantidade": 66, "valor_bruto": "1875.72", "valor_compra": 2137.349577464789, "investidor_id": 1, "valor_liquido": 2137.349577464789}	2	1687561447
10243	app\\models\\financas\\ItensAtivo	update	{"id": 9, "ativo": true, "ativo_id": 25, "quantidade": 253, "valor_bruto": "2532.53", "valor_compra": 3667.1575510204075, "investidor_id": 1, "valor_liquido": 3667.1575510204075}	2	1687561447
10244	app\\models\\financas\\ItensAtivo	update	{"id": 45, "ativo": true, "ativo_id": 29, "quantidade": 1.339, "valor_bruto": "141.35823", "valor_compra": 195.19, "investidor_id": 2, "valor_liquido": 195.19}	2	1687561447
10245	app\\models\\financas\\ItensAtivo	update	{"id": 40, "ativo": true, "ativo_id": 33, "quantidade": 200.19100000000006, "valor_bruto": "18205.01", "valor_compra": 16686.979999999996, "investidor_id": 1, "valor_liquido": 16686.979999999996}	2	1687561447
10246	app\\models\\financas\\ItensAtivo	update	{"id": 20, "ativo": true, "ativo_id": 11, "quantidade": 1, "valor_bruto": "1372.36", "valor_compra": 1000, "investidor_id": 1, "valor_liquido": 1000}	2	1687561447
10247	app\\models\\financas\\ItensAtivo	update	{"id": 21, "ativo": true, "ativo_id": 3, "quantidade": 3.54, "valor_bruto": "12899.76", "valor_compra": 7963.17, "investidor_id": 1, "valor_liquido": 7963.17}	2	1687561447
10248	app\\models\\financas\\ItensAtivo	update	{"id": 26, "ativo": true, "ativo_id": 16, "quantidade": 427, "valor_bruto": "3744.79", "valor_compra": 5110.2303999999995, "investidor_id": 1, "valor_liquido": 5110.2303999999995}	2	1687561447
10249	app\\models\\financas\\ItensAtivo	update	{"id": 28, "ativo": true, "ativo_id": 17, "quantidade": 288, "valor_bruto": "4066.56", "valor_compra": 4473.49, "investidor_id": 1, "valor_liquido": 4473.49}	2	1687561447
10250	app\\models\\financas\\ItensAtivo	update	{"id": 29, "ativo": true, "ativo_id": 18, "quantidade": 306, "valor_bruto": "3552.66", "valor_compra": 5180.159999999999, "investidor_id": 1, "valor_liquido": 5180.159999999999}	2	1687561447
10251	app\\models\\financas\\ItensAtivo	update	{"id": 30, "ativo": true, "ativo_id": 19, "quantidade": 85, "valor_bruto": "3485.85", "valor_compra": 3712.14144144144, "investidor_id": 1, "valor_liquido": 3712.14144144144}	2	1687561447
10252	app\\models\\financas\\ItensAtivo	update	{"id": 25, "ativo": true, "ativo_id": 20, "quantidade": 174, "valor_bruto": "2510.82", "valor_compra": 4350.53, "investidor_id": 1, "valor_liquido": 4350.53}	2	1687561447
10253	app\\models\\financas\\ItensAtivo	update	{"id": 32, "ativo": true, "ativo_id": 29, "quantidade": 17.2086, "valor_bruto": "1816.711902", "valor_compra": 2783.3500000000004, "investidor_id": 1, "valor_liquido": 2783.3500000000004}	2	1687561447
10254	app\\models\\financas\\ItensAtivo	update	{"id": 33, "ativo": true, "ativo_id": 30, "quantidade": 21.2842, "valor_bruto": "2275.068138", "valor_compra": 2111.97, "investidor_id": 1, "valor_liquido": 2111.97}	2	1687561447
10255	app\\models\\financas\\ItensAtivo	update	{"id": 41, "ativo": true, "ativo_id": 30, "quantidade": 2.9489300000000003, "valor_bruto": "315.2111277", "valor_compra": 376.96000000000004, "investidor_id": 2, "valor_liquido": 376.96000000000004}	2	1687561447
10256	app\\models\\financas\\ItensAtivo	update	{"id": 34, "ativo": true, "ativo_id": 32, "quantidade": 10.22714, "valor_bruto": "3121.1185852", "valor_compra": 2434.7699999999995, "investidor_id": 1, "valor_liquido": 2434.7699999999995}	2	1687561447
10257	app\\models\\financas\\ItensAtivo	update	{"id": 39, "ativo": true, "ativo_id": 32, "quantidade": 1.3328600000000002, "valor_bruto": "406.7622148", "valor_compra": 365.53999999999996, "investidor_id": 2, "valor_liquido": 365.53999999999996}	2	1687561447
10258	app\\models\\financas\\ItensAtivo	update	{"id": 35, "ativo": true, "ativo_id": 34, "quantidade": 8.75256, "valor_bruto": "2411.7679080", "valor_compra": 2342.8399999999997, "investidor_id": 1, "valor_liquido": 2342.8399999999997}	2	1687561447
10259	app\\models\\financas\\ItensAtivo	update	{"id": 42, "ativo": true, "ativo_id": 35, "quantidade": 1.61888, "valor_bruto": "270.7900576", "valor_compra": 171.02, "investidor_id": 2, "valor_liquido": 171.02}	2	1687561447
10260	app\\models\\financas\\ItensAtivo	update	{"id": 36, "ativo": true, "ativo_id": 35, "quantidade": 21.396400000000003, "valor_bruto": "3578.975828", "valor_compra": 1517.678203181342, "investidor_id": 1, "valor_liquido": 1517.678203181342}	2	1687561447
10261	app\\models\\financas\\ItensAtivo	update	{"id": 37, "ativo": true, "ativo_id": 37, "quantidade": 70.21576000000002, "valor_bruto": "2649.2406248", "valor_compra": 2387.24, "investidor_id": 1, "valor_liquido": 2387.24}	2	1687561447
10262	app\\models\\financas\\ItensAtivo	update	{"id": 38, "ativo": true, "ativo_id": 37, "quantidade": 10.82491, "valor_bruto": "408.4238543", "valor_compra": 373, "investidor_id": 2, "valor_liquido": 373}	2	1687561447
10263	app\\models\\financas\\ItensAtivo	update	{"id": 10, "ativo": true, "ativo_id": 38, "quantidade": 48, "valor_bruto": "7799.52", "valor_compra": 8095.378039215686, "investidor_id": 1, "valor_liquido": 8095.378039215686}	2	1687561447
10264	app\\models\\financas\\ItensAtivo	update	{"id": 11, "ativo": true, "ativo_id": 39, "quantidade": 80, "valor_bruto": "8176.80", "valor_compra": 8406.587307692309, "investidor_id": 1, "valor_liquido": 8406.587307692309}	2	1687561447
10265	app\\models\\financas\\ItensAtivo	update	{"id": 14, "ativo": true, "ativo_id": 39, "quantidade": 11, "valor_bruto": "1124.31", "valor_compra": 1053.18, "investidor_id": 2, "valor_liquido": 1053.18}	2	1687561447
10266	app\\models\\financas\\ItensAtivo	update	{"id": 12, "ativo": true, "ativo_id": 40, "quantidade": 69, "valor_bruto": "7112.52", "valor_compra": 7105.83443139785, "investidor_id": 1, "valor_liquido": 7105.83443139785}	2	1687561447
10267	app\\models\\financas\\ItensAtivo	update	{"id": 17, "ativo": true, "ativo_id": 40, "quantidade": 10, "valor_bruto": "1030.80", "valor_compra": 1022, "investidor_id": 2, "valor_liquido": 1022}	2	1687561447
10268	app\\models\\financas\\ItensAtivo	update	{"id": 13, "ativo": true, "ativo_id": 42, "quantidade": 174, "valor_bruto": "14414.16", "valor_compra": 18020.090099999998, "investidor_id": 1, "valor_liquido": 18020.090099999998}	2	1687561447
10269	app\\models\\financas\\ItensAtivo	update	{"id": 43, "ativo": true, "ativo_id": 49, "quantidade": 129, "valor_bruto": "14490.57", "valor_compra": 15093.679979999995, "investidor_id": 1, "valor_liquido": 15093.679979999995}	2	1687561447
10270	app\\models\\financas\\ItensAtivo	update	{"id": 44, "ativo": true, "ativo_id": 50, "quantidade": 1.35168, "valor_bruto": "320.0643072", "valor_compra": 277, "investidor_id": 1, "valor_liquido": 277}	2	1687561447
10271	app\\models\\financas\\ItensAtivo	update	{"id": 46, "ativo": true, "ativo_id": 51, "quantidade": 0.01867941, "valor_bruto": "2753.04616344", "valor_compra": 2187, "investidor_id": 1, "valor_liquido": 2187}	2	1687561447
10272	app\\models\\financas\\ItensAtivo	update	{"id": 48, "ativo": true, "ativo_id": 53, "quantidade": 317, "valor_bruto": "2472.60", "valor_compra": 2565.677596439169, "investidor_id": 1, "valor_liquido": 2565.677596439169}	2	1687561447
10273	app\\models\\financas\\ItensAtivo	update	{"id": 49, "ativo": true, "ativo_id": 54, "quantidade": 16.726, "valor_bruto": "2081.55070", "valor_compra": 2006.81, "investidor_id": 1, "valor_liquido": 2006.81}	2	1687561447
10274	app\\models\\financas\\ItensAtivo	update	{"id": 51, "ativo": true, "ativo_id": 54, "quantidade": 1.61444, "valor_bruto": "200.9170580", "valor_compra": 181.78, "investidor_id": 2, "valor_liquido": 181.78}	2	1687561447
10275	app\\models\\financas\\ItensAtivo	update	{"id": 50, "ativo": true, "ativo_id": 55, "quantidade": 6.13338, "valor_bruto": "384.5015922", "valor_compra": 380.8, "investidor_id": 2, "valor_liquido": 380.8}	2	1687561447
10276	app\\models\\financas\\ItensAtivo	update	{"id": 52, "ativo": true, "ativo_id": 55, "quantidade": 28.52771, "valor_bruto": "1788.4021399", "valor_compra": 1912.6799999999998, "investidor_id": 1, "valor_liquido": 1912.6799999999998}	2	1687561447
10277	app\\models\\financas\\ItensAtivo	update	{"id": 26, "ativo": true, "ativo_id": 16, "quantidade": "427", "valor_bruto": "3744.79", "valor_compra": "5110.2304", "investidor_id": 1, "valor_liquido": "3744.79"}	2	1687561454
10278	app\\models\\financas\\ItensAtivo	update	{"id": 28, "ativo": true, "ativo_id": 17, "quantidade": "288", "valor_bruto": "4066.56", "valor_compra": "4473.49", "investidor_id": 1, "valor_liquido": "4066.56"}	2	1687561454
10279	app\\models\\financas\\ItensAtivo	update	{"id": 29, "ativo": true, "ativo_id": 18, "quantidade": "306", "valor_bruto": "3552.66", "valor_compra": "5180.16", "investidor_id": 1, "valor_liquido": "3552.66"}	2	1687561454
10280	app\\models\\financas\\ItensAtivo	update	{"id": 30, "ativo": true, "ativo_id": 19, "quantidade": "85", "valor_bruto": "3485.85", "valor_compra": "3712.1414414414", "investidor_id": 1, "valor_liquido": "3485.85"}	2	1687561454
10281	app\\models\\financas\\ItensAtivo	update	{"id": 25, "ativo": true, "ativo_id": 20, "quantidade": "174", "valor_bruto": "2510.82", "valor_compra": "4350.53", "investidor_id": 1, "valor_liquido": "2510.82"}	2	1687561454
10282	app\\models\\financas\\ItensAtivo	update	{"id": 27, "ativo": true, "ativo_id": 21, "quantidade": "71", "valor_bruto": "2904.61", "valor_compra": "1509.9557966102", "investidor_id": 1, "valor_liquido": "2904.61"}	2	1687561454
10283	app\\models\\financas\\ItensAtivo	update	{"id": 31, "ativo": true, "ativo_id": 23, "quantidade": "616", "valor_bruto": "5001.92", "valor_compra": "4831.21", "investidor_id": 1, "valor_liquido": "5001.92"}	2	1687561454
10284	app\\models\\financas\\ItensAtivo	update	{"id": 8, "ativo": true, "ativo_id": 24, "quantidade": "66", "valor_bruto": "1875.72", "valor_compra": "2137.3495774648", "investidor_id": 1, "valor_liquido": "1875.72"}	2	1687561454
10285	app\\models\\financas\\ItensAtivo	update	{"id": 9, "ativo": true, "ativo_id": 25, "quantidade": "253", "valor_bruto": "2532.53", "valor_compra": "3667.1575510204", "investidor_id": 1, "valor_liquido": "2532.53"}	2	1687561454
10286	app\\models\\financas\\ItensAtivo	update	{"id": 45, "ativo": true, "ativo_id": 29, "quantidade": "1.339", "valor_bruto": "141.35823", "valor_compra": "195.19", "investidor_id": 2, "valor_liquido": "141.35823"}	2	1687561454
10287	app\\models\\financas\\ItensAtivo	update	{"id": 32, "ativo": true, "ativo_id": 29, "quantidade": "17.2086", "valor_bruto": "1816.711902", "valor_compra": "2783.35", "investidor_id": 1, "valor_liquido": "1816.711902"}	2	1687561454
10288	app\\models\\financas\\ItensAtivo	update	{"id": 33, "ativo": true, "ativo_id": 30, "quantidade": "21.2842", "valor_bruto": "2275.068138", "valor_compra": "2111.97", "investidor_id": 1, "valor_liquido": "2275.068138"}	2	1687561454
10289	app\\models\\financas\\ItensAtivo	update	{"id": 41, "ativo": true, "ativo_id": 30, "quantidade": "2.94893", "valor_bruto": "315.2111277", "valor_compra": "376.96", "investidor_id": 2, "valor_liquido": "315.2111277"}	2	1687561454
10290	app\\models\\financas\\ItensAtivo	update	{"id": 34, "ativo": true, "ativo_id": 32, "quantidade": "10.22714", "valor_bruto": "3121.1185852", "valor_compra": "2434.77", "investidor_id": 1, "valor_liquido": "3121.1185852"}	2	1687561454
10291	app\\models\\financas\\ItensAtivo	update	{"id": 39, "ativo": true, "ativo_id": 32, "quantidade": "1.33286", "valor_bruto": "406.7622148", "valor_compra": "365.54", "investidor_id": 2, "valor_liquido": "406.7622148"}	2	1687561454
10292	app\\models\\financas\\ItensAtivo	update	{"id": 35, "ativo": true, "ativo_id": 34, "quantidade": "8.75256", "valor_bruto": "2411.7679080", "valor_compra": "2342.84", "investidor_id": 1, "valor_liquido": "2411.7679080"}	2	1687561454
10293	app\\models\\financas\\ItensAtivo	update	{"id": 42, "ativo": true, "ativo_id": 35, "quantidade": "1.61888", "valor_bruto": "270.7900576", "valor_compra": "171.02", "investidor_id": 2, "valor_liquido": "270.7900576"}	2	1687561454
10294	app\\models\\financas\\ItensAtivo	update	{"id": 36, "ativo": true, "ativo_id": 35, "quantidade": "21.3964", "valor_bruto": "3578.975828", "valor_compra": "1517.6782031813", "investidor_id": 1, "valor_liquido": "3578.975828"}	2	1687561454
10295	app\\models\\financas\\ItensAtivo	update	{"id": 37, "ativo": true, "ativo_id": 37, "quantidade": "70.21576", "valor_bruto": "2649.2406248", "valor_compra": "2387.24", "investidor_id": 1, "valor_liquido": "2649.2406248"}	2	1687561454
10296	app\\models\\financas\\ItensAtivo	update	{"id": 38, "ativo": true, "ativo_id": 37, "quantidade": "10.82491", "valor_bruto": "408.4238543", "valor_compra": "373", "investidor_id": 2, "valor_liquido": "408.4238543"}	2	1687561454
10297	app\\models\\financas\\ItensAtivo	update	{"id": 10, "ativo": true, "ativo_id": 38, "quantidade": "48", "valor_bruto": "7799.52", "valor_compra": "8095.3780392157", "investidor_id": 1, "valor_liquido": "7799.52"}	2	1687561454
10298	app\\models\\financas\\ItensAtivo	update	{"id": 11, "ativo": true, "ativo_id": 39, "quantidade": "80", "valor_bruto": "8176.80", "valor_compra": "8406.5873076923", "investidor_id": 1, "valor_liquido": "8176.80"}	2	1687561454
10299	app\\models\\financas\\ItensAtivo	update	{"id": 14, "ativo": true, "ativo_id": 39, "quantidade": "11", "valor_bruto": "1124.31", "valor_compra": "1053.18", "investidor_id": 2, "valor_liquido": "1124.31"}	2	1687561454
10300	app\\models\\financas\\ItensAtivo	update	{"id": 12, "ativo": true, "ativo_id": 40, "quantidade": "69", "valor_bruto": "7112.52", "valor_compra": "7105.8344313978", "investidor_id": 1, "valor_liquido": "7112.52"}	2	1687561454
10301	app\\models\\financas\\ItensAtivo	update	{"id": 17, "ativo": true, "ativo_id": 40, "quantidade": "10", "valor_bruto": "1030.80", "valor_compra": "1022", "investidor_id": 2, "valor_liquido": "1030.80"}	2	1687561454
10302	app\\models\\financas\\ItensAtivo	update	{"id": 13, "ativo": true, "ativo_id": 42, "quantidade": "174", "valor_bruto": "14414.16", "valor_compra": "18020.0901", "investidor_id": 1, "valor_liquido": "14414.16"}	2	1687561454
10303	app\\models\\financas\\ItensAtivo	update	{"id": 43, "ativo": true, "ativo_id": 49, "quantidade": "129", "valor_bruto": "14490.57", "valor_compra": "15093.67998", "investidor_id": 1, "valor_liquido": "14490.57"}	2	1687561454
10304	app\\models\\financas\\ItensAtivo	update	{"id": 44, "ativo": true, "ativo_id": 50, "quantidade": "1.35168", "valor_bruto": "320.0643072", "valor_compra": "277", "investidor_id": 1, "valor_liquido": "320.0643072"}	2	1687561454
10305	app\\models\\financas\\ItensAtivo	update	{"id": 46, "ativo": true, "ativo_id": 51, "quantidade": "0.01867941", "valor_bruto": "2753.04616344", "valor_compra": "2187", "investidor_id": 1, "valor_liquido": "2753.04616344"}	2	1687561454
10306	app\\models\\financas\\ItensAtivo	update	{"id": 48, "ativo": true, "ativo_id": 53, "quantidade": "317", "valor_bruto": "2472.60", "valor_compra": "2565.6775964392", "investidor_id": 1, "valor_liquido": "2472.60"}	2	1687561454
10307	app\\models\\financas\\ItensAtivo	update	{"id": 49, "ativo": true, "ativo_id": 54, "quantidade": "16.726", "valor_bruto": "2081.55070", "valor_compra": "2006.81", "investidor_id": 1, "valor_liquido": "2081.55070"}	2	1687561454
10308	app\\models\\financas\\ItensAtivo	update	{"id": 51, "ativo": true, "ativo_id": 54, "quantidade": "1.61444", "valor_bruto": "200.9170580", "valor_compra": "181.78", "investidor_id": 2, "valor_liquido": "200.9170580"}	2	1687561454
10309	app\\models\\financas\\ItensAtivo	update	{"id": 50, "ativo": true, "ativo_id": 55, "quantidade": "6.13338", "valor_bruto": "384.5015922", "valor_compra": "380.8", "investidor_id": 2, "valor_liquido": "384.5015922"}	2	1687561454
10310	app\\models\\financas\\ItensAtivo	update	{"id": 52, "ativo": true, "ativo_id": 55, "quantidade": "28.52771", "valor_bruto": "1788.4021399", "valor_compra": "1912.68", "investidor_id": 1, "valor_liquido": "1788.4021399"}	2	1687561454
10311	app\\models\\financas\\Operacao	insert	{"id": 817, "data": "2023-06-21 20:05:11", "tipo": "2", "valor": 0, "quantidade": "7", "itens_ativos_id": "48"}	2	1687561643
10312	app\\models\\financas\\ItensAtivo	update	{"id": 48, "ativo": true, "ativo_id": 53, "quantidade": 324, "valor_bruto": "2472.60", "valor_compra": "2565.6775964392", "investidor_id": 1, "valor_liquido": "2472.60"}	2	1687561643
10313	app\\models\\financas\\Operacao	insert	{"id": 818, "data": "2023-06-21 17:05:07", "tipo": "3", "valor": 0, "quantidade": "7", "itens_ativos_id": "8"}	2	1687561764
10314	app\\models\\financas\\ItensAtivo	update	{"id": 8, "ativo": true, "ativo_id": 24, "quantidade": 59, "valor_bruto": "1875.72", "valor_compra": "2137.3495774648", "investidor_id": 1, "valor_liquido": "1875.72"}	2	1687561764
10557	app\\models\\financas\\ItensAtivo	update	{"id": 14, "ativo": true, "ativo_id": 39, "quantidade": 111, "valor_bruto": 11345.31, "valor_compra": 11053.18, "investidor_id": 2, "valor_liquido": 11345.31}	2	1687705976
10558	app\\models\\financas\\Operacao	insert	{"id": 837, "data": "2023-06-25 12:15:43", "tipo": "0", "valor": "1100", "quantidade": "10", "itens_ativos_id": "14"}	2	1687706065
10559	app\\models\\financas\\ItensAtivo	update	{"id": 14, "ativo": true, "ativo_id": 39, "quantidade": 101, "valor_bruto": 10323.21, "valor_compra": 10057.398018018019, "investidor_id": 2, "valor_liquido": 10323.21}	2	1687706066
10560	app\\models\\financas\\Operacao	insert	{"id": 838, "data": "2023-06-25 12:20:06", "tipo": "2", "valor": 0, "quantidade": "100", "itens_ativos_id": "14"}	2	1687706136
10561	app\\models\\financas\\ItensAtivo	update	{"id": 14, "ativo": true, "ativo_id": 39, "quantidade": 201, "valor_bruto": "10323.21", "valor_compra": "10057.398018018", "investidor_id": 2, "valor_liquido": "10323.21"}	2	1687706136
10562	app\\models\\financas\\Operacao	insert	{"id": 839, "data": "2023-06-25 12:25:28", "tipo": "0", "valor": "1500", "quantidade": "15", "itens_ativos_id": "14"}	2	1687706228
10563	app\\models\\financas\\ItensAtivo	update	{"id": 14, "ativo": true, "ativo_id": 39, "quantidade": 186, "valor_bruto": 19011.059999999998, "valor_compra": 9271.626927970607, "investidor_id": 2, "valor_liquido": 19011.059999999998}	2	1687706228
10564	app\\models\\financas\\Operacao	insert	{"id": 840, "data": "2023-06-25 12:30:56", "tipo": "3", "valor": 0, "quantidade": "100", "itens_ativos_id": "14"}	2	1687706302
10565	app\\models\\financas\\ItensAtivo	update	{"id": 14, "ativo": true, "ativo_id": 39, "quantidade": 86, "valor_bruto": "19011.06", "valor_compra": "9271.6269279706", "investidor_id": 2, "valor_liquido": "19011.06"}	2	1687706302
10566	app\\models\\financas\\Operacao	insert	{"id": 841, "data": "2023-06-25 12:35:33", "tipo": "1", "valor": "1274", "quantidade": "13", "itens_ativos_id": "11"}	2	1687706368
10567	app\\models\\financas\\ItensAtivo	update	{"id": 11, "ativo": true, "ativo_id": 39, "quantidade": 93, "valor_bruto": 9505.529999999999, "valor_compra": 9680.5873076923, "investidor_id": 1, "valor_liquido": 9505.529999999999}	2	1687706368
10568	app\\models\\financas\\Operacao	update	{"id": 841, "data": "2023-06-25 12:35:33", "tipo": "1", "valor": "1274", "quantidade": "13", "itens_ativos_id": "14"}	2	1687706452
10569	app\\models\\financas\\ItensAtivo	update	{"id": 14, "ativo": true, "ativo_id": 39, "quantidade": 99, "valor_bruto": "19011.06", "valor_compra": 10580.845927121152, "investidor_id": 2, "valor_liquido": 10580.845927121152}	2	1687706452
10570	app\\models\\financas\\ItensAtivo	update	{"id": 14, "ativo": true, "ativo_id": 39, "quantidade": "99", "valor_bruto": "10118.79", "valor_compra": "10580.845927121", "investidor_id": 2, "valor_liquido": "10118.79"}	2	1687706452
10571	app\\models\\financas\\Operacao	update	{"id": 837, "data": "2023-06-25 12:15:43", "tipo": "1", "valor": "1100", "quantidade": "10", "itens_ativos_id": "14"}	2	1687710358
10572	app\\models\\financas\\ItensAtivo	update	{"id": 14, "ativo": true, "ativo_id": 39, "quantidade": 119, "valor_bruto": "10118.79", "valor_compra": 12602.303529411765, "investidor_id": 2, "valor_liquido": "10118.79"}	2	1687710358
10573	app\\models\\financas\\ItensAtivo	update	{"id": 14, "ativo": true, "ativo_id": 39, "quantidade": "119", "valor_bruto": "12162.99", "valor_compra": "12602.303529412", "investidor_id": 2, "valor_liquido": "12162.99"}	2	1687710358
10574	app\\models\\financas\\Operacao	update	{"id": 837, "data": "2023-06-25 12:15:43", "tipo": "0", "valor": "1100", "quantidade": "10", "itens_ativos_id": "14"}	2	1687710427
10575	app\\models\\financas\\ItensAtivo	update	{"id": 14, "ativo": true, "ativo_id": 39, "quantidade": 99, "valor_bruto": "12162.99", "valor_compra": 10580.845927121152, "investidor_id": 2, "valor_liquido": "12162.99"}	2	1687710427
10576	app\\models\\financas\\ItensAtivo	update	{"id": 14, "ativo": true, "ativo_id": 39, "quantidade": "99", "valor_bruto": "10118.79", "valor_compra": "10580.845927121", "investidor_id": 2, "valor_liquido": "10118.79"}	2	1687710427
10577	app\\models\\financas\\ItensAtivo	update	{"id": 22, "ativo": true, "ativo_id": 36, "quantidade": 0.33, "valor_bruto": "1068.21", "valor_compra": 984.95, "investidor_id": 1, "valor_liquido": "984.95"}	2	1687712119
10578	app\\models\\financas\\ItensAtivo	update	{"id": 47, "ativo": true, "ativo_id": 52, "quantidade": 2.8000000000000003, "valor_bruto": "35593.75", "valor_compra": 32934.780000000006, "investidor_id": 1, "valor_liquido": "32934.78"}	2	1687712119
10579	app\\models\\financas\\ItensAtivo	update	{"id": 55, "ativo": true, "ativo_id": 57, "quantidade": 0.08, "valor_bruto": "1033.09", "valor_compra": 1033.09, "investidor_id": 2, "valor_liquido": "1033.09"}	2	1687712119
10580	app\\models\\financas\\ItensAtivo	update	{"id": 53, "ativo": true, "ativo_id": 57, "quantidade": 0.71, "valor_bruto": "7992.3", "valor_compra": 9008.13, "investidor_id": 1, "valor_liquido": "9008.13"}	2	1687712119
10581	app\\models\\financas\\ItensAtivo	update	{"id": 54, "ativo": true, "ativo_id": 52, "quantidade": 0.08, "valor_bruto": "1012.86", "valor_compra": 1012.86, "investidor_id": 2, "valor_liquido": "1012.86"}	2	1687712119
10582	app\\models\\financas\\ItensAtivo	update	{"id": 23, "ativo": true, "ativo_id": 41, "quantidade": 0.7299999999999999, "valor_bruto": "8385.16", "valor_compra": 8385.16, "investidor_id": 2, "valor_liquido": "8385.16"}	2	1687712119
10583	app\\models\\financas\\ItensAtivo	update	{"id": 40, "ativo": true, "ativo_id": 33, "quantidade": 200.19100000000006, "valor_bruto": "18205.01", "valor_compra": 16686.979999999996, "investidor_id": 1, "valor_liquido": "16686.98"}	2	1687712119
10584	app\\models\\financas\\ItensAtivo	update	{"id": 20, "ativo": true, "ativo_id": 11, "quantidade": 1, "valor_bruto": "1372.36", "valor_compra": 1000, "investidor_id": 1, "valor_liquido": "1000"}	2	1687712119
10585	app\\models\\financas\\ItensAtivo	update	{"id": 21, "ativo": true, "ativo_id": 3, "quantidade": 3.54, "valor_bruto": "12899.76", "valor_compra": 7963.17, "investidor_id": 1, "valor_liquido": "7963.17"}	2	1687712119
10586	app\\models\\financas\\ItensAtivo	update	{"id": 25, "ativo": true, "ativo_id": 20, "quantidade": 174, "valor_bruto": "2510.82", "valor_compra": 4350.53, "investidor_id": 1, "valor_liquido": "2510.82"}	2	1687712119
10587	app\\models\\financas\\ItensAtivo	update	{"id": 27, "ativo": true, "ativo_id": 21, "quantidade": 71, "valor_bruto": "2904.61", "valor_compra": 1509.9400000000003, "investidor_id": 1, "valor_liquido": "2904.61"}	2	1687712120
10588	app\\models\\financas\\ItensAtivo	update	{"id": 31, "ativo": true, "ativo_id": 23, "quantidade": 616, "valor_bruto": "5001.92", "valor_compra": 4831.209999999999, "investidor_id": 1, "valor_liquido": "5001.92"}	2	1687712120
10589	app\\models\\financas\\ItensAtivo	update	{"id": 26, "ativo": true, "ativo_id": 16, "quantidade": 427, "valor_bruto": "3744.79", "valor_compra": 5110.2303999999995, "investidor_id": 1, "valor_liquido": "3744.79"}	2	1687712120
10590	app\\models\\financas\\ItensAtivo	update	{"id": 28, "ativo": true, "ativo_id": 17, "quantidade": 288, "valor_bruto": "4066.56", "valor_compra": 4473.49, "investidor_id": 1, "valor_liquido": "4066.56"}	2	1687712120
10591	app\\models\\financas\\ItensAtivo	update	{"id": 29, "ativo": true, "ativo_id": 18, "quantidade": 306, "valor_bruto": "3552.66", "valor_compra": 5180.159999999999, "investidor_id": 1, "valor_liquido": "3552.66"}	2	1687712120
10592	app\\models\\financas\\ItensAtivo	update	{"id": 30, "ativo": true, "ativo_id": 19, "quantidade": 85, "valor_bruto": "3485.85", "valor_compra": 3712.199999999998, "investidor_id": 1, "valor_liquido": "3485.85"}	2	1687712120
10593	app\\models\\financas\\ItensAtivo	update	{"id": 9, "ativo": true, "ativo_id": 25, "quantidade": 253, "valor_bruto": "2532.53", "valor_compra": 3667.5799999999995, "investidor_id": 1, "valor_liquido": "2532.53"}	2	1687712120
10594	app\\models\\financas\\ItensAtivo	update	{"id": 45, "ativo": true, "ativo_id": 29, "quantidade": 1.339, "valor_bruto": "141.35823", "valor_compra": 195.19, "investidor_id": 2, "valor_liquido": "141.35823"}	2	1687712120
10595	app\\models\\financas\\ItensAtivo	update	{"id": 32, "ativo": true, "ativo_id": 29, "quantidade": 17.2086, "valor_bruto": "1816.711902", "valor_compra": 2783.3500000000004, "investidor_id": 1, "valor_liquido": "1816.711902"}	2	1687712120
10596	app\\models\\financas\\ItensAtivo	update	{"id": 33, "ativo": true, "ativo_id": 30, "quantidade": 21.2842, "valor_bruto": "2275.068138", "valor_compra": 2111.97, "investidor_id": 1, "valor_liquido": "2275.068138"}	2	1687712120
10597	app\\models\\financas\\ItensAtivo	update	{"id": 41, "ativo": true, "ativo_id": 30, "quantidade": 2.9489300000000003, "valor_bruto": "315.2111277", "valor_compra": 376.96000000000004, "investidor_id": 2, "valor_liquido": "315.2111277"}	2	1687712120
10598	app\\models\\financas\\ItensAtivo	update	{"id": 34, "ativo": true, "ativo_id": 32, "quantidade": 10.22714, "valor_bruto": "3121.1185852", "valor_compra": 2434.7699999999995, "investidor_id": 1, "valor_liquido": "3121.1185852"}	2	1687712120
10599	app\\models\\financas\\ItensAtivo	update	{"id": 39, "ativo": true, "ativo_id": 32, "quantidade": 1.3328600000000002, "valor_bruto": "406.7622148", "valor_compra": 365.53999999999996, "investidor_id": 2, "valor_liquido": "406.7622148"}	2	1687712120
10600	app\\models\\financas\\ItensAtivo	update	{"id": 35, "ativo": true, "ativo_id": 34, "quantidade": 8.75256, "valor_bruto": "2411.7679080", "valor_compra": 2342.8399999999997, "investidor_id": 1, "valor_liquido": "2411.7679080"}	2	1687712120
10601	app\\models\\financas\\ItensAtivo	update	{"id": 42, "ativo": true, "ativo_id": 35, "quantidade": 1.61888, "valor_bruto": "270.7900576", "valor_compra": 171.02, "investidor_id": 2, "valor_liquido": "270.7900576"}	2	1687712120
10602	app\\models\\financas\\ItensAtivo	update	{"id": 36, "ativo": true, "ativo_id": 35, "quantidade": 21.396400000000003, "valor_bruto": "3578.975828", "valor_compra": 1517.69, "investidor_id": 1, "valor_liquido": "3578.975828"}	2	1687712120
10603	app\\models\\financas\\ItensAtivo	update	{"id": 37, "ativo": true, "ativo_id": 37, "quantidade": 70.21576000000002, "valor_bruto": "2649.2406248", "valor_compra": 2387.24, "investidor_id": 1, "valor_liquido": "2649.2406248"}	2	1687712120
10604	app\\models\\financas\\ItensAtivo	update	{"id": 38, "ativo": true, "ativo_id": 37, "quantidade": 10.82491, "valor_bruto": "408.4238543", "valor_compra": 373, "investidor_id": 2, "valor_liquido": "408.4238543"}	2	1687712120
10605	app\\models\\financas\\ItensAtivo	update	{"id": 10, "ativo": true, "ativo_id": 38, "quantidade": 48, "valor_bruto": "7799.52", "valor_compra": 8095.279999999999, "investidor_id": 1, "valor_liquido": "7799.52"}	2	1687712120
10606	app\\models\\financas\\ItensAtivo	update	{"id": 12, "ativo": true, "ativo_id": 40, "quantidade": 69, "valor_bruto": "7112.52", "valor_compra": 7105.800039999999, "investidor_id": 1, "valor_liquido": "7112.52"}	2	1687712120
10607	app\\models\\financas\\ItensAtivo	update	{"id": 17, "ativo": true, "ativo_id": 40, "quantidade": 10, "valor_bruto": "1030.80", "valor_compra": 1022, "investidor_id": 2, "valor_liquido": "1030.80"}	2	1687712120
10608	app\\models\\financas\\ItensAtivo	update	{"id": 13, "ativo": true, "ativo_id": 42, "quantidade": 174, "valor_bruto": "14414.16", "valor_compra": 18020.090099999998, "investidor_id": 1, "valor_liquido": "14414.16"}	2	1687712120
10609	app\\models\\financas\\ItensAtivo	update	{"id": 43, "ativo": true, "ativo_id": 49, "quantidade": 129, "valor_bruto": "14490.57", "valor_compra": 15093.679979999995, "investidor_id": 1, "valor_liquido": "14490.57"}	2	1687712120
10610	app\\models\\financas\\ItensAtivo	update	{"id": 44, "ativo": true, "ativo_id": 50, "quantidade": 1.35168, "valor_bruto": "320.0643072", "valor_compra": 277, "investidor_id": 1, "valor_liquido": "320.0643072"}	2	1687712120
10611	app\\models\\financas\\ItensAtivo	update	{"id": 46, "ativo": true, "ativo_id": 51, "quantidade": 0.01867941, "valor_bruto": "2753.04616344", "valor_compra": 2187, "investidor_id": 1, "valor_liquido": "2753.04616344"}	2	1687712120
10612	app\\models\\financas\\ItensAtivo	update	{"id": 49, "ativo": true, "ativo_id": 54, "quantidade": 16.726, "valor_bruto": "2081.55070", "valor_compra": 2006.81, "investidor_id": 1, "valor_liquido": "2081.55070"}	2	1687712120
10613	app\\models\\financas\\ItensAtivo	update	{"id": 51, "ativo": true, "ativo_id": 54, "quantidade": 1.61444, "valor_bruto": "200.9170580", "valor_compra": 181.78, "investidor_id": 2, "valor_liquido": "200.9170580"}	2	1687712120
10614	app\\models\\financas\\ItensAtivo	update	{"id": 50, "ativo": true, "ativo_id": 55, "quantidade": 6.13338, "valor_bruto": "384.5015922", "valor_compra": 380.8, "investidor_id": 2, "valor_liquido": "384.5015922"}	2	1687712120
10615	app\\models\\financas\\ItensAtivo	update	{"id": 52, "ativo": true, "ativo_id": 55, "quantidade": 28.52771, "valor_bruto": "1788.4021399", "valor_compra": 1912.6799999999998, "investidor_id": 1, "valor_liquido": "1788.4021399"}	2	1687712120
10616	app\\models\\financas\\ItensAtivo	update	{"id": 48, "ativo": true, "ativo_id": 53, "quantidade": 324, "valor_bruto": "2472.60", "valor_compra": 2565.7499999999995, "investidor_id": 1, "valor_liquido": "2472.60"}	2	1687712120
10617	app\\models\\financas\\ItensAtivo	update	{"id": 8, "ativo": true, "ativo_id": 24, "quantidade": 59, "valor_bruto": "1875.72", "valor_compra": 2137.3600000000006, "investidor_id": 1, "valor_liquido": "1875.72"}	2	1687712120
10618	app\\models\\financas\\ItensAtivo	update	{"id": 11, "ativo": true, "ativo_id": 39, "quantidade": 80, "valor_bruto": "9505.53", "valor_compra": 8406.570000000002, "investidor_id": 1, "valor_liquido": "9505.53"}	2	1687712120
10619	app\\models\\financas\\ItensAtivo	update	{"id": 14, "ativo": true, "ativo_id": 39, "quantidade": 99, "valor_bruto": "10118.79", "valor_compra": 10580.78, "investidor_id": 2, "valor_liquido": "10118.79"}	2	1687712120
10620	app\\models\\financas\\ItensAtivo	update	{"id": 48, "ativo": true, "ativo_id": 53, "quantidade": 324, "valor_bruto": "2472.60", "valor_compra": 2565.7499999999995, "investidor_id": 1, "valor_liquido": "2472.60"}	2	1687712356
10621	app\\models\\financas\\ItensAtivo	update	{"id": 8, "ativo": true, "ativo_id": 24, "quantidade": 59, "valor_bruto": "1875.72", "valor_compra": 2137.3600000000006, "investidor_id": 1, "valor_liquido": "1875.72"}	2	1687712356
10622	app\\models\\financas\\ItensAtivo	update	{"id": 11, "ativo": true, "ativo_id": 39, "quantidade": 80, "valor_bruto": "9505.53", "valor_compra": 8406.570000000002, "investidor_id": 1, "valor_liquido": "9505.53"}	2	1687712356
10623	app\\models\\financas\\ItensAtivo	update	{"id": 14, "ativo": true, "ativo_id": 39, "quantidade": 99, "valor_bruto": "10118.79", "valor_compra": 10580.78, "investidor_id": 2, "valor_liquido": "10118.79"}	2	1687712356
10624	app\\models\\financas\\ItensAtivo	update	{"id": 22, "ativo": true, "ativo_id": 36, "quantidade": 0.33, "valor_bruto": "1068.21", "valor_compra": 984.95, "investidor_id": 1, "valor_liquido": "984.95"}	2	1687712356
10625	app\\models\\financas\\ItensAtivo	update	{"id": 47, "ativo": true, "ativo_id": 52, "quantidade": 2.8000000000000003, "valor_bruto": "35593.75", "valor_compra": 32934.780000000006, "investidor_id": 1, "valor_liquido": "32934.78"}	2	1687712356
10626	app\\models\\financas\\ItensAtivo	update	{"id": 55, "ativo": true, "ativo_id": 57, "quantidade": 0.08, "valor_bruto": "1033.09", "valor_compra": 1033.09, "investidor_id": 2, "valor_liquido": "1033.09"}	2	1687712356
10627	app\\models\\financas\\ItensAtivo	update	{"id": 53, "ativo": true, "ativo_id": 57, "quantidade": 0.71, "valor_bruto": "7992.3", "valor_compra": 9008.13, "investidor_id": 1, "valor_liquido": "9008.13"}	2	1687712356
10628	app\\models\\financas\\ItensAtivo	update	{"id": 54, "ativo": true, "ativo_id": 52, "quantidade": 0.08, "valor_bruto": "1012.86", "valor_compra": 1012.86, "investidor_id": 2, "valor_liquido": "1012.86"}	2	1687712356
10629	app\\models\\financas\\ItensAtivo	update	{"id": 23, "ativo": true, "ativo_id": 41, "quantidade": 0.7299999999999999, "valor_bruto": "8385.16", "valor_compra": 8385.16, "investidor_id": 2, "valor_liquido": "8385.16"}	2	1687712356
10630	app\\models\\financas\\ItensAtivo	update	{"id": 40, "ativo": true, "ativo_id": 33, "quantidade": 200.19100000000006, "valor_bruto": "18205.01", "valor_compra": 16686.979999999996, "investidor_id": 1, "valor_liquido": "16686.98"}	2	1687712356
10631	app\\models\\financas\\ItensAtivo	update	{"id": 20, "ativo": true, "ativo_id": 11, "quantidade": 1, "valor_bruto": "1372.36", "valor_compra": 1000, "investidor_id": 1, "valor_liquido": "1000"}	2	1687712356
10632	app\\models\\financas\\ItensAtivo	update	{"id": 21, "ativo": true, "ativo_id": 3, "quantidade": 3.54, "valor_bruto": "12899.76", "valor_compra": 7963.17, "investidor_id": 1, "valor_liquido": "7963.17"}	2	1687712356
10633	app\\models\\financas\\ItensAtivo	update	{"id": 25, "ativo": true, "ativo_id": 20, "quantidade": 174, "valor_bruto": "2510.82", "valor_compra": 4350.53, "investidor_id": 1, "valor_liquido": "2510.82"}	2	1687712356
10634	app\\models\\financas\\ItensAtivo	update	{"id": 27, "ativo": true, "ativo_id": 21, "quantidade": 71, "valor_bruto": "2904.61", "valor_compra": 1509.9400000000003, "investidor_id": 1, "valor_liquido": "2904.61"}	2	1687712356
10635	app\\models\\financas\\ItensAtivo	update	{"id": 31, "ativo": true, "ativo_id": 23, "quantidade": 616, "valor_bruto": "5001.92", "valor_compra": 4831.209999999999, "investidor_id": 1, "valor_liquido": "5001.92"}	2	1687712356
10636	app\\models\\financas\\ItensAtivo	update	{"id": 26, "ativo": true, "ativo_id": 16, "quantidade": 427, "valor_bruto": "3744.79", "valor_compra": 5110.2303999999995, "investidor_id": 1, "valor_liquido": "3744.79"}	2	1687712356
10637	app\\models\\financas\\ItensAtivo	update	{"id": 28, "ativo": true, "ativo_id": 17, "quantidade": 288, "valor_bruto": "4066.56", "valor_compra": 4473.49, "investidor_id": 1, "valor_liquido": "4066.56"}	2	1687712356
10638	app\\models\\financas\\ItensAtivo	update	{"id": 29, "ativo": true, "ativo_id": 18, "quantidade": 306, "valor_bruto": "3552.66", "valor_compra": 5180.159999999999, "investidor_id": 1, "valor_liquido": "3552.66"}	2	1687712356
10639	app\\models\\financas\\ItensAtivo	update	{"id": 30, "ativo": true, "ativo_id": 19, "quantidade": 85, "valor_bruto": "3485.85", "valor_compra": 3712.199999999998, "investidor_id": 1, "valor_liquido": "3485.85"}	2	1687712356
10640	app\\models\\financas\\ItensAtivo	update	{"id": 9, "ativo": true, "ativo_id": 25, "quantidade": 253, "valor_bruto": "2532.53", "valor_compra": 3667.5799999999995, "investidor_id": 1, "valor_liquido": "2532.53"}	2	1687712356
10641	app\\models\\financas\\ItensAtivo	update	{"id": 45, "ativo": true, "ativo_id": 29, "quantidade": 1.339, "valor_bruto": "141.35823", "valor_compra": 195.19, "investidor_id": 2, "valor_liquido": "141.35823"}	2	1687712356
10642	app\\models\\financas\\ItensAtivo	update	{"id": 32, "ativo": true, "ativo_id": 29, "quantidade": 17.2086, "valor_bruto": "1816.711902", "valor_compra": 2783.3500000000004, "investidor_id": 1, "valor_liquido": "1816.711902"}	2	1687712356
10643	app\\models\\financas\\ItensAtivo	update	{"id": 33, "ativo": true, "ativo_id": 30, "quantidade": 21.2842, "valor_bruto": "2275.068138", "valor_compra": 2111.97, "investidor_id": 1, "valor_liquido": "2275.068138"}	2	1687712356
10644	app\\models\\financas\\ItensAtivo	update	{"id": 41, "ativo": true, "ativo_id": 30, "quantidade": 2.9489300000000003, "valor_bruto": "315.2111277", "valor_compra": 376.96000000000004, "investidor_id": 2, "valor_liquido": "315.2111277"}	2	1687712356
10645	app\\models\\financas\\ItensAtivo	update	{"id": 34, "ativo": true, "ativo_id": 32, "quantidade": 10.22714, "valor_bruto": "3121.1185852", "valor_compra": 2434.7699999999995, "investidor_id": 1, "valor_liquido": "3121.1185852"}	2	1687712356
10646	app\\models\\financas\\ItensAtivo	update	{"id": 39, "ativo": true, "ativo_id": 32, "quantidade": 1.3328600000000002, "valor_bruto": "406.7622148", "valor_compra": 365.53999999999996, "investidor_id": 2, "valor_liquido": "406.7622148"}	2	1687712356
10647	app\\models\\financas\\ItensAtivo	update	{"id": 35, "ativo": true, "ativo_id": 34, "quantidade": 8.75256, "valor_bruto": "2411.7679080", "valor_compra": 2342.8399999999997, "investidor_id": 1, "valor_liquido": "2411.7679080"}	2	1687712356
10648	app\\models\\financas\\ItensAtivo	update	{"id": 42, "ativo": true, "ativo_id": 35, "quantidade": 1.61888, "valor_bruto": "270.7900576", "valor_compra": 171.02, "investidor_id": 2, "valor_liquido": "270.7900576"}	2	1687712356
10649	app\\models\\financas\\ItensAtivo	update	{"id": 36, "ativo": true, "ativo_id": 35, "quantidade": 21.396400000000003, "valor_bruto": "3578.975828", "valor_compra": 1517.69, "investidor_id": 1, "valor_liquido": "3578.975828"}	2	1687712356
10650	app\\models\\financas\\ItensAtivo	update	{"id": 37, "ativo": true, "ativo_id": 37, "quantidade": 70.21576000000002, "valor_bruto": "2649.2406248", "valor_compra": 2387.24, "investidor_id": 1, "valor_liquido": "2649.2406248"}	2	1687712356
10651	app\\models\\financas\\ItensAtivo	update	{"id": 38, "ativo": true, "ativo_id": 37, "quantidade": 10.82491, "valor_bruto": "408.4238543", "valor_compra": 373, "investidor_id": 2, "valor_liquido": "408.4238543"}	2	1687712356
10652	app\\models\\financas\\ItensAtivo	update	{"id": 10, "ativo": true, "ativo_id": 38, "quantidade": 48, "valor_bruto": "7799.52", "valor_compra": 8095.279999999999, "investidor_id": 1, "valor_liquido": "7799.52"}	2	1687712356
10653	app\\models\\financas\\ItensAtivo	update	{"id": 12, "ativo": true, "ativo_id": 40, "quantidade": 69, "valor_bruto": "7112.52", "valor_compra": 7105.800039999999, "investidor_id": 1, "valor_liquido": "7112.52"}	2	1687712356
10654	app\\models\\financas\\ItensAtivo	update	{"id": 17, "ativo": true, "ativo_id": 40, "quantidade": 10, "valor_bruto": "1030.80", "valor_compra": 1022, "investidor_id": 2, "valor_liquido": "1030.80"}	2	1687712356
10655	app\\models\\financas\\ItensAtivo	update	{"id": 13, "ativo": true, "ativo_id": 42, "quantidade": 174, "valor_bruto": "14414.16", "valor_compra": 18020.090099999998, "investidor_id": 1, "valor_liquido": "14414.16"}	2	1687712356
10656	app\\models\\financas\\ItensAtivo	update	{"id": 43, "ativo": true, "ativo_id": 49, "quantidade": 129, "valor_bruto": "14490.57", "valor_compra": 15093.679979999995, "investidor_id": 1, "valor_liquido": "14490.57"}	2	1687712356
10657	app\\models\\financas\\ItensAtivo	update	{"id": 44, "ativo": true, "ativo_id": 50, "quantidade": 1.35168, "valor_bruto": "320.0643072", "valor_compra": 277, "investidor_id": 1, "valor_liquido": "320.0643072"}	2	1687712356
10658	app\\models\\financas\\ItensAtivo	update	{"id": 46, "ativo": true, "ativo_id": 51, "quantidade": 0.01867941, "valor_bruto": "2753.04616344", "valor_compra": 2187, "investidor_id": 1, "valor_liquido": "2753.04616344"}	2	1687712356
10659	app\\models\\financas\\ItensAtivo	update	{"id": 49, "ativo": true, "ativo_id": 54, "quantidade": 16.726, "valor_bruto": "2081.55070", "valor_compra": 2006.81, "investidor_id": 1, "valor_liquido": "2081.55070"}	2	1687712356
10660	app\\models\\financas\\ItensAtivo	update	{"id": 51, "ativo": true, "ativo_id": 54, "quantidade": 1.61444, "valor_bruto": "200.9170580", "valor_compra": 181.78, "investidor_id": 2, "valor_liquido": "200.9170580"}	2	1687712356
10661	app\\models\\financas\\ItensAtivo	update	{"id": 50, "ativo": true, "ativo_id": 55, "quantidade": 6.13338, "valor_bruto": "384.5015922", "valor_compra": 380.8, "investidor_id": 2, "valor_liquido": "384.5015922"}	2	1687712356
10662	app\\models\\financas\\ItensAtivo	update	{"id": 52, "ativo": true, "ativo_id": 55, "quantidade": 28.52771, "valor_bruto": "1788.4021399", "valor_compra": 1912.6799999999998, "investidor_id": 1, "valor_liquido": "1788.4021399"}	2	1687712356
10663	app\\models\\financas\\ItensAtivo	update	{"id": 52, "ativo": true, "ativo_id": 55, "quantidade": 28.52771, "valor_bruto": "1788.4021399", "valor_compra": 1912.6799999999998, "investidor_id": 1, "valor_liquido": "1788.4021399"}	2	1687712403
10664	app\\models\\financas\\ItensAtivo	update	{"id": 48, "ativo": true, "ativo_id": 53, "quantidade": 324, "valor_bruto": "2472.60", "valor_compra": 2565.677596439169, "investidor_id": 1, "valor_liquido": "2472.60"}	2	1687712403
10665	app\\models\\financas\\ItensAtivo	update	{"id": 8, "ativo": true, "ativo_id": 24, "quantidade": 59, "valor_bruto": "1875.72", "valor_compra": 2137.349577464789, "investidor_id": 1, "valor_liquido": "1875.72"}	2	1687712403
10666	app\\models\\financas\\ItensAtivo	update	{"id": 11, "ativo": true, "ativo_id": 39, "quantidade": 80, "valor_bruto": "9505.53", "valor_compra": 8406.587307692309, "investidor_id": 1, "valor_liquido": "9505.53"}	2	1687712403
10667	app\\models\\financas\\ItensAtivo	update	{"id": 14, "ativo": true, "ativo_id": 39, "quantidade": 99, "valor_bruto": "10118.79", "valor_compra": 10580.845927121152, "investidor_id": 2, "valor_liquido": "10118.79"}	2	1687712403
10668	app\\models\\financas\\ItensAtivo	update	{"id": 22, "ativo": true, "ativo_id": 36, "quantidade": 0.33, "valor_bruto": "1068.21", "valor_compra": 984.95, "investidor_id": 1, "valor_liquido": "984.95"}	2	1687712403
10669	app\\models\\financas\\ItensAtivo	update	{"id": 47, "ativo": true, "ativo_id": 52, "quantidade": 2.8000000000000003, "valor_bruto": "35593.75", "valor_compra": 32934.780000000006, "investidor_id": 1, "valor_liquido": "32934.78"}	2	1687712403
10670	app\\models\\financas\\ItensAtivo	update	{"id": 55, "ativo": true, "ativo_id": 57, "quantidade": 0.08, "valor_bruto": "1033.09", "valor_compra": 1033.09, "investidor_id": 2, "valor_liquido": "1033.09"}	2	1687712403
10671	app\\models\\financas\\ItensAtivo	update	{"id": 53, "ativo": true, "ativo_id": 57, "quantidade": 0.71, "valor_bruto": "7992.3", "valor_compra": 9008.13, "investidor_id": 1, "valor_liquido": "9008.13"}	2	1687712403
10672	app\\models\\financas\\ItensAtivo	update	{"id": 54, "ativo": true, "ativo_id": 52, "quantidade": 0.08, "valor_bruto": "1012.86", "valor_compra": 1012.86, "investidor_id": 2, "valor_liquido": "1012.86"}	2	1687712403
10673	app\\models\\financas\\ItensAtivo	update	{"id": 23, "ativo": true, "ativo_id": 41, "quantidade": 0.7299999999999999, "valor_bruto": "8385.16", "valor_compra": 8385.16, "investidor_id": 2, "valor_liquido": "8385.16"}	2	1687712403
10674	app\\models\\financas\\ItensAtivo	update	{"id": 40, "ativo": true, "ativo_id": 33, "quantidade": 200.19100000000006, "valor_bruto": "18205.01", "valor_compra": 16686.979999999996, "investidor_id": 1, "valor_liquido": "16686.98"}	2	1687712403
10675	app\\models\\financas\\ItensAtivo	update	{"id": 20, "ativo": true, "ativo_id": 11, "quantidade": 1, "valor_bruto": "1372.36", "valor_compra": 1000, "investidor_id": 1, "valor_liquido": "1000"}	2	1687712403
10676	app\\models\\financas\\ItensAtivo	update	{"id": 21, "ativo": true, "ativo_id": 3, "quantidade": 3.54, "valor_bruto": "12899.76", "valor_compra": 7963.17, "investidor_id": 1, "valor_liquido": "7963.17"}	2	1687712403
10677	app\\models\\financas\\ItensAtivo	update	{"id": 25, "ativo": true, "ativo_id": 20, "quantidade": 174, "valor_bruto": "2510.82", "valor_compra": 4350.53, "investidor_id": 1, "valor_liquido": "2510.82"}	2	1687712403
10678	app\\models\\financas\\ItensAtivo	update	{"id": 27, "ativo": true, "ativo_id": 21, "quantidade": 71, "valor_bruto": "2904.61", "valor_compra": 1509.9557966101697, "investidor_id": 1, "valor_liquido": "2904.61"}	2	1687712403
10679	app\\models\\financas\\ItensAtivo	update	{"id": 31, "ativo": true, "ativo_id": 23, "quantidade": 616, "valor_bruto": "5001.92", "valor_compra": 4831.209999999999, "investidor_id": 1, "valor_liquido": "5001.92"}	2	1687712403
10680	app\\models\\financas\\ItensAtivo	update	{"id": 26, "ativo": true, "ativo_id": 16, "quantidade": 427, "valor_bruto": "3744.79", "valor_compra": 5110.2303999999995, "investidor_id": 1, "valor_liquido": "3744.79"}	2	1687712403
10681	app\\models\\financas\\ItensAtivo	update	{"id": 28, "ativo": true, "ativo_id": 17, "quantidade": 288, "valor_bruto": "4066.56", "valor_compra": 4473.49, "investidor_id": 1, "valor_liquido": "4066.56"}	2	1687712403
10682	app\\models\\financas\\ItensAtivo	update	{"id": 29, "ativo": true, "ativo_id": 18, "quantidade": 306, "valor_bruto": "3552.66", "valor_compra": 5180.159999999999, "investidor_id": 1, "valor_liquido": "3552.66"}	2	1687712403
10683	app\\models\\financas\\ItensAtivo	update	{"id": 30, "ativo": true, "ativo_id": 19, "quantidade": 85, "valor_bruto": "3485.85", "valor_compra": 3712.14144144144, "investidor_id": 1, "valor_liquido": "3485.85"}	2	1687712403
10684	app\\models\\financas\\ItensAtivo	update	{"id": 9, "ativo": true, "ativo_id": 25, "quantidade": 253, "valor_bruto": "2532.53", "valor_compra": 3667.1575510204075, "investidor_id": 1, "valor_liquido": "2532.53"}	2	1687712403
10685	app\\models\\financas\\ItensAtivo	update	{"id": 45, "ativo": true, "ativo_id": 29, "quantidade": 1.339, "valor_bruto": "141.35823", "valor_compra": 195.19, "investidor_id": 2, "valor_liquido": "141.35823"}	2	1687712403
10686	app\\models\\financas\\ItensAtivo	update	{"id": 32, "ativo": true, "ativo_id": 29, "quantidade": 17.2086, "valor_bruto": "1816.711902", "valor_compra": 2783.3500000000004, "investidor_id": 1, "valor_liquido": "1816.711902"}	2	1687712403
10687	app\\models\\financas\\ItensAtivo	update	{"id": 33, "ativo": true, "ativo_id": 30, "quantidade": 21.2842, "valor_bruto": "2275.068138", "valor_compra": 2111.97, "investidor_id": 1, "valor_liquido": "2275.068138"}	2	1687712403
10688	app\\models\\financas\\ItensAtivo	update	{"id": 41, "ativo": true, "ativo_id": 30, "quantidade": 2.9489300000000003, "valor_bruto": "315.2111277", "valor_compra": 376.96000000000004, "investidor_id": 2, "valor_liquido": "315.2111277"}	2	1687712403
10689	app\\models\\financas\\ItensAtivo	update	{"id": 34, "ativo": true, "ativo_id": 32, "quantidade": 10.22714, "valor_bruto": "3121.1185852", "valor_compra": 2434.7699999999995, "investidor_id": 1, "valor_liquido": "3121.1185852"}	2	1687712403
10690	app\\models\\financas\\ItensAtivo	update	{"id": 39, "ativo": true, "ativo_id": 32, "quantidade": 1.3328600000000002, "valor_bruto": "406.7622148", "valor_compra": 365.53999999999996, "investidor_id": 2, "valor_liquido": "406.7622148"}	2	1687712403
10691	app\\models\\financas\\ItensAtivo	update	{"id": 35, "ativo": true, "ativo_id": 34, "quantidade": 8.75256, "valor_bruto": "2411.7679080", "valor_compra": 2342.8399999999997, "investidor_id": 1, "valor_liquido": "2411.7679080"}	2	1687712403
10692	app\\models\\financas\\ItensAtivo	update	{"id": 42, "ativo": true, "ativo_id": 35, "quantidade": 1.61888, "valor_bruto": "270.7900576", "valor_compra": 171.02, "investidor_id": 2, "valor_liquido": "270.7900576"}	2	1687712403
10693	app\\models\\financas\\ItensAtivo	update	{"id": 36, "ativo": true, "ativo_id": 35, "quantidade": 21.396400000000003, "valor_bruto": "3578.975828", "valor_compra": 1517.678203181342, "investidor_id": 1, "valor_liquido": "3578.975828"}	2	1687712403
10694	app\\models\\financas\\ItensAtivo	update	{"id": 37, "ativo": true, "ativo_id": 37, "quantidade": 70.21576000000002, "valor_bruto": "2649.2406248", "valor_compra": 2387.24, "investidor_id": 1, "valor_liquido": "2649.2406248"}	2	1687712404
10695	app\\models\\financas\\ItensAtivo	update	{"id": 38, "ativo": true, "ativo_id": 37, "quantidade": 10.82491, "valor_bruto": "408.4238543", "valor_compra": 373, "investidor_id": 2, "valor_liquido": "408.4238543"}	2	1687712404
10696	app\\models\\financas\\ItensAtivo	update	{"id": 10, "ativo": true, "ativo_id": 38, "quantidade": 48, "valor_bruto": "7799.52", "valor_compra": 8095.378039215686, "investidor_id": 1, "valor_liquido": "7799.52"}	2	1687712404
10697	app\\models\\financas\\ItensAtivo	update	{"id": 12, "ativo": true, "ativo_id": 40, "quantidade": 69, "valor_bruto": "7112.52", "valor_compra": 7105.83443139785, "investidor_id": 1, "valor_liquido": "7112.52"}	2	1687712404
10698	app\\models\\financas\\ItensAtivo	update	{"id": 17, "ativo": true, "ativo_id": 40, "quantidade": 10, "valor_bruto": "1030.80", "valor_compra": 1022, "investidor_id": 2, "valor_liquido": "1030.80"}	2	1687712404
10699	app\\models\\financas\\ItensAtivo	update	{"id": 13, "ativo": true, "ativo_id": 42, "quantidade": 174, "valor_bruto": "14414.16", "valor_compra": 18020.090099999998, "investidor_id": 1, "valor_liquido": "14414.16"}	2	1687712404
10700	app\\models\\financas\\ItensAtivo	update	{"id": 43, "ativo": true, "ativo_id": 49, "quantidade": 129, "valor_bruto": "14490.57", "valor_compra": 15093.679979999995, "investidor_id": 1, "valor_liquido": "14490.57"}	2	1687712404
10701	app\\models\\financas\\ItensAtivo	update	{"id": 44, "ativo": true, "ativo_id": 50, "quantidade": 1.35168, "valor_bruto": "320.0643072", "valor_compra": 277, "investidor_id": 1, "valor_liquido": "320.0643072"}	2	1687712404
10702	app\\models\\financas\\ItensAtivo	update	{"id": 46, "ativo": true, "ativo_id": 51, "quantidade": 0.01867941, "valor_bruto": "2753.04616344", "valor_compra": 2187, "investidor_id": 1, "valor_liquido": "2753.04616344"}	2	1687712404
10703	app\\models\\financas\\ItensAtivo	update	{"id": 49, "ativo": true, "ativo_id": 54, "quantidade": 16.726, "valor_bruto": "2081.55070", "valor_compra": 2006.81, "investidor_id": 1, "valor_liquido": "2081.55070"}	2	1687712404
10704	app\\models\\financas\\ItensAtivo	update	{"id": 51, "ativo": true, "ativo_id": 54, "quantidade": 1.61444, "valor_bruto": "200.9170580", "valor_compra": 181.78, "investidor_id": 2, "valor_liquido": "200.9170580"}	2	1687712404
10705	app\\models\\financas\\ItensAtivo	update	{"id": 50, "ativo": true, "ativo_id": 55, "quantidade": 6.13338, "valor_bruto": "384.5015922", "valor_compra": 380.8, "investidor_id": 2, "valor_liquido": "384.5015922"}	2	1687712404
10706	app\\models\\financas\\ItensAtivo	update	{"id": 52, "ativo": true, "ativo_id": 55, "quantidade": 28.52771, "valor_bruto": "1788.4021399", "valor_compra": 1912.6799999999998, "investidor_id": 1, "valor_liquido": "1788.4021399"}	2	1687712570
10707	app\\models\\financas\\ItensAtivo	update	{"id": 48, "ativo": true, "ativo_id": 53, "quantidade": 324, "valor_bruto": "2472.60", "valor_compra": 2565.677596439169, "investidor_id": 1, "valor_liquido": "2472.60"}	2	1687712570
10708	app\\models\\financas\\ItensAtivo	update	{"id": 8, "ativo": true, "ativo_id": 24, "quantidade": 59, "valor_bruto": "1875.72", "valor_compra": 2137.349577464789, "investidor_id": 1, "valor_liquido": "1875.72"}	2	1687712570
10709	app\\models\\financas\\ItensAtivo	update	{"id": 11, "ativo": true, "ativo_id": 39, "quantidade": 80, "valor_bruto": "9505.53", "valor_compra": 8406.587307692309, "investidor_id": 1, "valor_liquido": "9505.53"}	2	1687712570
10710	app\\models\\financas\\ItensAtivo	update	{"id": 48, "ativo": true, "ativo_id": 53, "quantidade": 324, "valor_bruto": "2472.60", "valor_compra": 2565.7499999999995, "investidor_id": 1, "valor_liquido": "2472.60"}	2	1687712612
10711	app\\models\\financas\\ItensAtivo	update	{"id": 8, "ativo": true, "ativo_id": 24, "quantidade": 59, "valor_bruto": "1875.72", "valor_compra": 2137.3600000000006, "investidor_id": 1, "valor_liquido": "1875.72"}	2	1687712612
10712	app\\models\\financas\\ItensAtivo	update	{"id": 11, "ativo": true, "ativo_id": 39, "quantidade": 80, "valor_bruto": "9505.53", "valor_compra": 8406.570000000002, "investidor_id": 1, "valor_liquido": "9505.53"}	2	1687712612
10713	app\\models\\financas\\ItensAtivo	update	{"id": 48, "ativo": true, "ativo_id": 53, "quantidade": 324, "valor_bruto": "2472.60", "valor_compra": 2565.7499999999995, "investidor_id": 1, "valor_liquido": "2472.60"}	2	1687712651
10714	app\\models\\financas\\ItensAtivo	update	{"id": 14, "ativo": true, "ativo_id": 39, "quantidade": 99, "valor_bruto": "10118.79", "valor_compra": 10580.845927121152, "investidor_id": 2, "valor_liquido": "10118.79"}	2	1687715068
10715	app\\models\\financas\\ItensAtivo	update	{"id": 22, "ativo": true, "ativo_id": 36, "quantidade": 0.33, "valor_bruto": "1068.21", "valor_compra": 984.95, "investidor_id": 1, "valor_liquido": "984.95"}	2	1687715068
10716	app\\models\\financas\\ItensAtivo	update	{"id": 47, "ativo": true, "ativo_id": 52, "quantidade": 2.8000000000000003, "valor_bruto": "35593.75", "valor_compra": 32934.780000000006, "investidor_id": 1, "valor_liquido": "32934.78"}	2	1687715068
10717	app\\models\\financas\\ItensAtivo	update	{"id": 55, "ativo": true, "ativo_id": 57, "quantidade": 0.08, "valor_bruto": "1033.09", "valor_compra": 1033.09, "investidor_id": 2, "valor_liquido": "1033.09"}	2	1687715068
10718	app\\models\\financas\\ItensAtivo	update	{"id": 53, "ativo": true, "ativo_id": 57, "quantidade": 0.71, "valor_bruto": "7992.3", "valor_compra": 9008.13, "investidor_id": 1, "valor_liquido": "9008.13"}	2	1687715068
10719	app\\models\\financas\\ItensAtivo	update	{"id": 54, "ativo": true, "ativo_id": 52, "quantidade": 0.08, "valor_bruto": "1012.86", "valor_compra": 1012.86, "investidor_id": 2, "valor_liquido": "1012.86"}	2	1687715068
10720	app\\models\\financas\\ItensAtivo	update	{"id": 23, "ativo": true, "ativo_id": 41, "quantidade": 0.7299999999999999, "valor_bruto": "8385.16", "valor_compra": 8385.16, "investidor_id": 2, "valor_liquido": "8385.16"}	2	1687715068
10721	app\\models\\financas\\ItensAtivo	update	{"id": 40, "ativo": true, "ativo_id": 33, "quantidade": 200.19100000000006, "valor_bruto": "18205.01", "valor_compra": 16686.979999999996, "investidor_id": 1, "valor_liquido": "16686.98"}	2	1687715068
10722	app\\models\\financas\\ItensAtivo	update	{"id": 20, "ativo": true, "ativo_id": 11, "quantidade": 1, "valor_bruto": "1372.36", "valor_compra": 1000, "investidor_id": 1, "valor_liquido": "1000"}	2	1687715068
10723	app\\models\\financas\\ItensAtivo	update	{"id": 21, "ativo": true, "ativo_id": 3, "quantidade": 3.54, "valor_bruto": "12899.76", "valor_compra": 7963.17, "investidor_id": 1, "valor_liquido": "7963.17"}	2	1687715068
10724	app\\models\\financas\\ItensAtivo	update	{"id": 25, "ativo": true, "ativo_id": 20, "quantidade": 174, "valor_bruto": "2510.82", "valor_compra": 4350.53, "investidor_id": 1, "valor_liquido": "2510.82"}	2	1687715068
10725	app\\models\\financas\\ItensAtivo	update	{"id": 27, "ativo": true, "ativo_id": 21, "quantidade": 71, "valor_bruto": "2904.61", "valor_compra": 1509.9557966101697, "investidor_id": 1, "valor_liquido": "2904.61"}	2	1687715068
10726	app\\models\\financas\\ItensAtivo	update	{"id": 31, "ativo": true, "ativo_id": 23, "quantidade": 616, "valor_bruto": "5001.92", "valor_compra": 4831.209999999999, "investidor_id": 1, "valor_liquido": "5001.92"}	2	1687715068
10727	app\\models\\financas\\ItensAtivo	update	{"id": 26, "ativo": true, "ativo_id": 16, "quantidade": 427, "valor_bruto": "3744.79", "valor_compra": 5110.2303999999995, "investidor_id": 1, "valor_liquido": "3744.79"}	2	1687715068
10728	app\\models\\financas\\ItensAtivo	update	{"id": 28, "ativo": true, "ativo_id": 17, "quantidade": 288, "valor_bruto": "4066.56", "valor_compra": 4473.49, "investidor_id": 1, "valor_liquido": "4066.56"}	2	1687715068
10729	app\\models\\financas\\ItensAtivo	update	{"id": 29, "ativo": true, "ativo_id": 18, "quantidade": 306, "valor_bruto": "3552.66", "valor_compra": 5180.159999999999, "investidor_id": 1, "valor_liquido": "3552.66"}	2	1687715068
10730	app\\models\\financas\\ItensAtivo	update	{"id": 30, "ativo": true, "ativo_id": 19, "quantidade": 85, "valor_bruto": "3485.85", "valor_compra": 3712.14144144144, "investidor_id": 1, "valor_liquido": "3485.85"}	2	1687715068
10731	app\\models\\financas\\ItensAtivo	update	{"id": 9, "ativo": true, "ativo_id": 25, "quantidade": 253, "valor_bruto": "2532.53", "valor_compra": 3667.1575510204075, "investidor_id": 1, "valor_liquido": "2532.53"}	2	1687715068
10732	app\\models\\financas\\ItensAtivo	update	{"id": 45, "ativo": true, "ativo_id": 29, "quantidade": 1.339, "valor_bruto": "141.35823", "valor_compra": 195.19, "investidor_id": 2, "valor_liquido": "141.35823"}	2	1687715068
10733	app\\models\\financas\\ItensAtivo	update	{"id": 32, "ativo": true, "ativo_id": 29, "quantidade": 17.2086, "valor_bruto": "1816.711902", "valor_compra": 2783.3500000000004, "investidor_id": 1, "valor_liquido": "1816.711902"}	2	1687715068
10734	app\\models\\financas\\ItensAtivo	update	{"id": 33, "ativo": true, "ativo_id": 30, "quantidade": 21.2842, "valor_bruto": "2275.068138", "valor_compra": 2111.97, "investidor_id": 1, "valor_liquido": "2275.068138"}	2	1687715068
10735	app\\models\\financas\\ItensAtivo	update	{"id": 41, "ativo": true, "ativo_id": 30, "quantidade": 2.9489300000000003, "valor_bruto": "315.2111277", "valor_compra": 376.96000000000004, "investidor_id": 2, "valor_liquido": "315.2111277"}	2	1687715068
10736	app\\models\\financas\\ItensAtivo	update	{"id": 34, "ativo": true, "ativo_id": 32, "quantidade": 10.22714, "valor_bruto": "3121.1185852", "valor_compra": 2434.7699999999995, "investidor_id": 1, "valor_liquido": "3121.1185852"}	2	1687715068
10737	app\\models\\financas\\ItensAtivo	update	{"id": 39, "ativo": true, "ativo_id": 32, "quantidade": 1.3328600000000002, "valor_bruto": "406.7622148", "valor_compra": 365.53999999999996, "investidor_id": 2, "valor_liquido": "406.7622148"}	2	1687715068
10738	app\\models\\financas\\ItensAtivo	update	{"id": 35, "ativo": true, "ativo_id": 34, "quantidade": 8.75256, "valor_bruto": "2411.7679080", "valor_compra": 2342.8399999999997, "investidor_id": 1, "valor_liquido": "2411.7679080"}	2	1687715068
10739	app\\models\\financas\\ItensAtivo	update	{"id": 42, "ativo": true, "ativo_id": 35, "quantidade": 1.61888, "valor_bruto": "270.7900576", "valor_compra": 171.02, "investidor_id": 2, "valor_liquido": "270.7900576"}	2	1687715068
10740	app\\models\\financas\\ItensAtivo	update	{"id": 36, "ativo": true, "ativo_id": 35, "quantidade": 21.396400000000003, "valor_bruto": "3578.975828", "valor_compra": 1517.678203181342, "investidor_id": 1, "valor_liquido": "3578.975828"}	2	1687715068
10741	app\\models\\financas\\ItensAtivo	update	{"id": 37, "ativo": true, "ativo_id": 37, "quantidade": 70.21576000000002, "valor_bruto": "2649.2406248", "valor_compra": 2387.24, "investidor_id": 1, "valor_liquido": "2649.2406248"}	2	1687715069
10742	app\\models\\financas\\ItensAtivo	update	{"id": 38, "ativo": true, "ativo_id": 37, "quantidade": 10.82491, "valor_bruto": "408.4238543", "valor_compra": 373, "investidor_id": 2, "valor_liquido": "408.4238543"}	2	1687715069
10743	app\\models\\financas\\ItensAtivo	update	{"id": 10, "ativo": true, "ativo_id": 38, "quantidade": 48, "valor_bruto": "7799.52", "valor_compra": 8095.378039215686, "investidor_id": 1, "valor_liquido": "7799.52"}	2	1687715069
10744	app\\models\\financas\\ItensAtivo	update	{"id": 12, "ativo": true, "ativo_id": 40, "quantidade": 69, "valor_bruto": "7112.52", "valor_compra": 7105.83443139785, "investidor_id": 1, "valor_liquido": "7112.52"}	2	1687715069
10745	app\\models\\financas\\ItensAtivo	update	{"id": 17, "ativo": true, "ativo_id": 40, "quantidade": 10, "valor_bruto": "1030.80", "valor_compra": 1022, "investidor_id": 2, "valor_liquido": "1030.80"}	2	1687715069
10746	app\\models\\financas\\ItensAtivo	update	{"id": 13, "ativo": true, "ativo_id": 42, "quantidade": 174, "valor_bruto": "14414.16", "valor_compra": 18020.090099999998, "investidor_id": 1, "valor_liquido": "14414.16"}	2	1687715069
10747	app\\models\\financas\\ItensAtivo	update	{"id": 43, "ativo": true, "ativo_id": 49, "quantidade": 129, "valor_bruto": "14490.57", "valor_compra": 15093.679979999995, "investidor_id": 1, "valor_liquido": "14490.57"}	2	1687715069
10748	app\\models\\financas\\ItensAtivo	update	{"id": 44, "ativo": true, "ativo_id": 50, "quantidade": 1.35168, "valor_bruto": "320.0643072", "valor_compra": 277, "investidor_id": 1, "valor_liquido": "320.0643072"}	2	1687715069
10749	app\\models\\financas\\ItensAtivo	update	{"id": 46, "ativo": true, "ativo_id": 51, "quantidade": 0.01867941, "valor_bruto": "2753.04616344", "valor_compra": 2187, "investidor_id": 1, "valor_liquido": "2753.04616344"}	2	1687715069
10750	app\\models\\financas\\ItensAtivo	update	{"id": 49, "ativo": true, "ativo_id": 54, "quantidade": 16.726, "valor_bruto": "2081.55070", "valor_compra": 2006.81, "investidor_id": 1, "valor_liquido": "2081.55070"}	2	1687715069
10751	app\\models\\financas\\ItensAtivo	update	{"id": 51, "ativo": true, "ativo_id": 54, "quantidade": 1.61444, "valor_bruto": "200.9170580", "valor_compra": 181.78, "investidor_id": 2, "valor_liquido": "200.9170580"}	2	1687715069
10752	app\\models\\financas\\ItensAtivo	update	{"id": 50, "ativo": true, "ativo_id": 55, "quantidade": 6.13338, "valor_bruto": "384.5015922", "valor_compra": 380.8, "investidor_id": 2, "valor_liquido": "384.5015922"}	2	1687715069
10753	app\\models\\financas\\ItensAtivo	update	{"id": 8, "ativo": true, "ativo_id": 24, "quantidade": 59, "valor_bruto": "1875.72", "valor_compra": 2137.349577464789, "investidor_id": 1, "valor_liquido": "1875.72"}	2	1687715069
10754	app\\models\\financas\\ItensAtivo	update	{"id": 11, "ativo": true, "ativo_id": 39, "quantidade": 80, "valor_bruto": "9505.53", "valor_compra": 8406.587307692309, "investidor_id": 1, "valor_liquido": "9505.53"}	2	1687715069
10755	app\\models\\financas\\ItensAtivo	update	{"id": 48, "ativo": true, "ativo_id": 53, "quantidade": 324, "valor_bruto": "2472.60", "valor_compra": 2565.677596439169, "investidor_id": 1, "valor_liquido": "2472.60"}	2	1687715069
10756	app\\models\\financas\\ItensAtivo	update	{"id": 52, "ativo": true, "ativo_id": 55, "quantidade": 28.52771, "valor_bruto": "1788.4021399", "valor_compra": 1912.6799999999998, "investidor_id": 1, "valor_liquido": "1788.4021399"}	2	1687715069
\.


--
-- Data for Name: auth_assignment; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.auth_assignment (item_name, user_id, created_at) FROM stdin;
admin	2	\N
\.


--
-- Data for Name: auth_item; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.auth_item (name, type, description, rule_name, data, created_at, updated_at) FROM stdin;
admin	1	papel do administrador	\N	\N	\N	\N
\.


--
-- Data for Name: auth_item_child; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.auth_item_child (parent, child) FROM stdin;
\.


--
-- Data for Name: auth_rule; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.auth_rule (name, data, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: classes_operacoes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.classes_operacoes (id, nome) FROM stdin;
1	app\\lib\\config\\atualizaAtivos\\rendaVariavel\\CalculaPorMediaPreco
2	app\\lib\\config\\atualizaAtivos\\rendaFixa\\cdbInter\\CalculaAritimeticaCDBInter
3	app\\lib\\config\\atualizaAtivos\\rendaFixa\\normais\\CalculaAritimetica
\.


--
-- Data for Name: investidor; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.investidor (id, cpf, nome) FROM stdin;
1	91999375599	anderson mota
2	99979974699	ana vitoria
\.


--
-- Data for Name: itens_ativo; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.itens_ativo (id, ativo_id, investidor_id, quantidade, valor_compra, valor_liquido, valor_bruto, ativo) FROM stdin;
2	5	1	0	0	0	0	f
16	26	1	0.00	-69.5199	0	0	f
19	10	1	0	-162.78003	1188	1188	f
7	2	1	0.0	142.90002	0	0	f
5	15	1	0	-100	0	0	f
1	13	1	0	-892.9099	0	0	f
3	4	1	0.00	-2797.4414	0	0	f
4	1	1	0.00	-343.8401	0	0	f
24	14	1	0	-3986.0999	0	0	f
18	9	1	0	-248.84009	2268	2268	f
6	7	1	0.0	167.09009	0	0	f
15	31	1	0.00000	-58.370117	0.0000000	0.0000000	f
50	55	2	6.13338	380.8	384.5015922	384.5015922	t
8	24	1	59	2137.3495774648	1875.72	1875.72	t
11	39	1	80	8406.5873076923	9505.53	9505.53	t
48	53	1	324	2565.6775964392	2472.60	2472.60	t
52	55	1	28.52771	1912.68	1788.4021399	1788.4021399	t
14	39	2	99	10580.845927121	10118.79	10118.79	t
22	36	1	0.33	984.95	984.95	1068.21	t
47	52	1	2.8	32934.78	32934.78	35593.75	t
55	57	2	0.08	1033.09	1033.09	1033.09	t
53	57	1	0.71	9008.13	9008.13	7992.3	t
54	52	2	0.08	1012.86	1012.86	1012.86	t
23	41	2	0.73	8385.16	8385.16	8385.16	t
40	33	1	200.191	16686.98	16686.98	18205.01	t
20	11	1	1	1000	1000	1372.36	t
21	3	1	3.54	7963.17	7963.17	12899.76	t
25	20	1	174	4350.53	2510.82	2510.82	t
27	21	1	71	1509.9557966102	2904.61	2904.61	t
31	23	1	616	4831.21	5001.92	5001.92	t
26	16	1	427	5110.2304	3744.79	3744.79	t
28	17	1	288	4473.49	4066.56	4066.56	t
29	18	1	306	5180.16	3552.66	3552.66	t
30	19	1	85	3712.1414414414	3485.85	3485.85	t
9	25	1	253	3667.1575510204	2532.53	2532.53	t
45	29	2	1.339	195.19	141.35823	141.35823	t
32	29	1	17.2086	2783.35	1816.711902	1816.711902	t
33	30	1	21.2842	2111.97	2275.068138	2275.068138	t
41	30	2	2.94893	376.96	315.2111277	315.2111277	t
34	32	1	10.22714	2434.77	3121.1185852	3121.1185852	t
39	32	2	1.33286	365.54	406.7622148	406.7622148	t
35	34	1	8.75256	2342.84	2411.7679080	2411.7679080	t
42	35	2	1.61888	171.02	270.7900576	270.7900576	t
36	35	1	21.3964	1517.6782031813	3578.975828	3578.975828	t
37	37	1	70.21576	2387.24	2649.2406248	2649.2406248	t
38	37	2	10.82491	373	408.4238543	408.4238543	t
10	38	1	48	8095.3780392157	7799.52	7799.52	t
12	40	1	69	7105.8344313978	7112.52	7112.52	t
17	40	2	10	1022	1030.80	1030.80	t
13	42	1	174	18020.0901	14414.16	14414.16	t
43	49	1	129	15093.67998	14490.57	14490.57	t
44	50	1	1.35168	277	320.0643072	320.0643072	t
46	51	1	0.01867941	2187	2753.04616344	2753.04616344	t
49	54	1	16.726	2006.81	2081.55070	2081.55070	t
51	54	2	1.61444	181.78	200.9170580	200.9170580	t
\.


--
-- Data for Name: migration; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.migration (version, apply_time) FROM stdin;
m000000_000000_base	1560091597
app\\migrations\\m190609_143226_inicio	1560092072
app\\migrations\\m190703_143226_dados_acao	1562509809
app\\migrations\\m190818_143226_campo_ativo	1566155358
app\\migrations\\m190818_163226_link_empresa_bolsa	1566157644
app\\migrations\\m190909_163226_balanco_empresa_bolsa	1575978125
app\\migrations\\m191210_163226_atualiza_compras_clear	1575978125
app\\migrations\\m191210_173226_uniqui_data_ativo_compras_clear	1575979461
app\\migrations\\m200202_173226_ajuste_tabela_fundamentos	1580653840
app\\migrations\\m200208_173226_unique_data_empresa_balanco	1583585767
app\\migrations\\m200224_173226_cria_enuns	1583585767
app\\migrations\\m200307_173226_remove_table_categoria	1583586173
app\\migrations\\m200307_183226_ajusta_tipo	1583673524
app\\migrations\\m200310_203226_ajusta_balanco	1583881740
app\\migrations\\m200315_203226_rank	1584300128
app\\migrations\\m200321_113226_notificacao	1584806784
yii\\queue\\db\\migrations\\M161119140200Queue	1585168594
yii\\queue\\db\\migrations\\M170307170300Later	1585168594
yii\\queue\\db\\migrations\\M170509001400Retry	1585168594
yii\\queue\\db\\migrations\\M170601155600Priority	1585168594
app\\migrations\\m200507_113226_add_tipo_criptomoedas	1588854236
app\\migrations\\m200507_133226_add_muda_tipo_quantidade_operacao	1588855960
app\\migrations\\m200507_143226_add_muda_tipo_quantidade_ativo	1588856684
app\\migrations\\m200801_143226_altera_cidogo_acao_empresa	1608120541
app\\migrations\\m200801_143227_insere_pais_ativo	1608120541
app\\migrations\\m210206_113226_add_tipo_metais	1612621919
app\\migrations\\m210206_113227_add_tipo_ETFs	1612628757
app\\migrations\\m210211_113227_add_atualiza_acao	1613055337
app\\migrations\\m210220_113227_add_tipo_FIIs	1613825282
app\\migrations\\m210220_113228_proventos	1613827645
app\\migrations\\m210220_113230_arvore	1615474235
app\\migrations\\m210612_090230_investidos	1623502444
app\\migrations\\m210612_095630_popula_ativo	1623502918
app\\migrations\\m210721_114530_unique_ativo	1626879564
app\\migrations\\m211115_104530_insere_itens_ativo	1639251011
app\\migrations\\m211115_114530_reestrutura_banco	1639251012
yii\\queue\\db\\migrations\\M211218163000JobQueueSize	1645144215
app\\migrations\\m211229_141830_upload_operacao	1645144216
app\\migrations\\m220212_113330_altera_tipo_dados_ativo	1645144216
app\\migrations\\m140506_102106_rbac_init	1649453824
app\\migrations\\m170907_052038_rbac_add_index_on_auth_assignment_user_id	1649453824
app\\migrations\\m180523_151638_rbac_updates_indexes_without_prefix	1649453824
app\\migrations\\m180609_110543_rbac_update_mssql_trigger	1649453824
app\\migrations\\m220306_200630_ativos_atualizar_import	1649453824
app\\migrations\\m220328_203730_user	1649453824
app\\migrations\\m220403_192930_popula_user	1654468965
app\\migrations\\m220409_143630_auditoria	1654468965
app\\migrations\\m220508_133630_altera_tipo_auth	1654468965
app\\migrations\\m220531_202830_add_movimentacao_proventos	1654468965
app\\migrations\\m220611_133400_add_FK_operacoes	1675725568
app\\migrations\\m221213_173400_classes_operacoes	1675725568
app\\migrations\\m221229_143400_insere_classes_operacoes	1675725568
app\\migrations\\m221230_103400_tabela_preco_media	1675725568
app\\migrations\\m230108_153400_insere_classes_operacoes	1675725568
app\\migrations\\m230121_203400_atualiza_nu	1675725568
app\\migrations\\m230128_143400_atualiza_manual	1675725568
app\\migrations\\m230212_093400_nome_config	1676212149
app\\migrations\\m230523_103400_remove_tabela_preco_medio	1684849779
app\\migrations\\m230601_153627_add_site_acoes	1687100001
app\\migrations\\m230603_101327_add_atualizaAcoes	1687100001
app\\migrations\\m230604_192427_alteraClassOperacoes	1687100001
\.


--
-- Data for Name: operacao; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.operacao (id, quantidade, valor, data, tipo, itens_ativos_id) FROM stdin;
635	10	919	2021-12-06 12:10:00	1	11
636	2	185.06	2021-12-14 12:15:00	1	12
637	0.05867	172.97	2021-12-07 12:15:00	1	41
3	100	1241	2019-06-04 00:00:00	1	5
15	1	1217.93	2017-02-13 00:00:00	1	6
16	1	1198.49	2017-04-24 00:00:00	1	7
17	2	2000	2019-02-18 00:00:00	1	18
18	1	1000	2018-08-16 00:00:00	1	19
19	1	1000	2019-06-06 00:00:00	1	20
10	3.35	7399.46	2019-06-20 00:00:00	1	21
9	1.04	10433.1	2019-06-20 00:00:00	1	3
8	0.36	3501.51	2019-06-20 00:00:00	1	4
2	48	531.2	2019-06-04 00:00:00	1	24
21	0.02	202	2019-07-04 00:00:00	1	3
11	1	3000	2019-06-20 00:00:00	1	1
23	100	1358	2019-07-10 00:00:00	1	26
24	43	991.58	2019-07-24 00:00:00	1	27
25	39	928.98	2019-07-24 00:00:00	1	25
26	55	995.5	2019-07-24 00:00:00	1	28
27	24	1000.08	2019-07-24 00:00:00	1	29
28	21	989.52	2019-07-24 00:00:00	1	30
29	1	3892.91	2019-07-19 00:00:00	0	1
30	26	201.5	2019-07-25 00:00:00	1	31
31	13	513.24	2019-08-02 00:00:00	1	8
32	58	435	2019-08-02 00:00:00	1	31
66	3	48.72	2019-08-13 00:00:00	1	9
70	55	897.6	2019-08-16 00:00:00	1	9
72	8	297.36	2019-08-16 00:00:00	1	8
73	1	7.3	2019-08-16 00:00:00	1	31
76	5	36.95	2019-08-26 00:00:00	1	31
79	4	91.28	2019-09-03 00:00:00	1	27
80	5	100.8	2019-09-03 00:00:00	1	24
81	5	120.3	2019-09-03 00:00:00	1	25
82	3	133.68	2019-09-03 00:00:00	1	30
83	9	321.12	2019-09-03 00:00:00	1	8
84	49	380.24	2019-09-03 00:00:00	1	31
86	5	87.8	2019-09-10 00:00:00	1	24
88	8	64	2019-09-10 00:00:00	1	31
89	2	74.1	2019-09-10 00:00:00	1	8
90	5	115.85	2019-09-10 00:00:00	1	27
91	7	132.58	2019-09-10 00:00:00	1	28
92	6	141.42	2019-09-10 00:00:00	1	25
94	16	252.96	2019-09-10 00:00:00	1	9
95	1	8.48	2019-10-02 00:00:00	1	31
96	1	18.93	2019-10-02 00:00:00	1	28
97	1	42.96	2019-10-02 00:00:00	1	29
98	1	25.27	2019-10-02 00:00:00	1	25
99	3	38.13	2019-10-02 00:00:00	1	26
100	3	47.16	2019-10-02 00:00:00	1	9
102	4	70.2	2019-10-02 00:00:00	1	24
103	3	72.42	2019-10-02 00:00:00	1	27
105	6	209.64	2019-10-02 00:00:00	1	8
106	5	220.05	2019-10-02 00:00:00	1	30
108	14	238.42	2019-11-04 00:00:00	1	24
111	6	83.34	2019-11-04 00:00:00	1	26
112	2	92.32	2019-11-04 00:00:00	1	30
113	8	206.08	2019-11-04 00:00:00	1	25
114	14	215.04	2019-11-04 00:00:00	1	9
110	3	78.63	2019-11-04 00:00:00	1	27
109	17	295.62	2019-11-04 00:00:00	1	28
93	11	193.16	2019-09-10 00:00:01	1	24
104	7	132.51	2019-10-02 00:00:01	1	28
107	6	257.88	2019-10-02 00:00:01	1	29
87	8	126.8	2019-09-10 00:00:01	1	9
77	1	7.81	2019-09-03 00:00:01	1	31
101	7	59.36	2019-10-02 00:00:01	1	31
78	1	44.5	2019-09-03 00:00:01	1	30
85	1	12.97	2019-09-10 00:00:00	1	26
129	1	11.32	2019-12-05 10:09:23	1	31
130	18	280.26	2019-12-05 10:08:38	1	24
131	5	56.05	2019-12-05 10:05:34	1	31
132	3	140.22	2019-12-05 10:04:08	1	30
133	12	164.28	2019-12-05 10:03:17	1	26
134	11	367.18	2019-12-05 10:02:24	1	8
22	100	1341	2019-07-10 00:00:00	0	5
135	0.12	1255.76	2020-01-03 10:05:00	1	3
136	0.09	941.5	2019-12-30 10:50:00	1	3
137	0.05	521.29	2019-12-03 10:10:00	1	3
196	0.09	945.38	2020-02-04 05:30:00	1	3
229	0.17	507.39	2020-02-04 10:15:00	1	21
230	0.02	56.32	2019-08-13 10:25:00	1	21
232	1	41.29	2020-02-04 12:55:24	1	27
234	1	53.02	2020-02-04 12:54:17	1	30
235	0.5	555.86	2020-02-17 08:50:00	0	6
236	0.5	555.86	2020-02-17 08:50:00	0	7
237	0.54	1100.12	2020-02-21 10:30:00	1	16
238	1	14.87	2020-03-03 13:48:26	1	28
239	14	140.42	2020-03-03 13:47:13	1	31
240	23	298.77	2020-03-03 13:46:50	1	26
241	7	347.9	2020-03-03 13:46:22	1	29
243	0.05	89.29	2020-03-16 21:25:00	1	16
244	0.02	210.87	2020-03-13 21:30:00	1	3
274	2	76.48	2020-04-02 10:37:53	1	30
275	5	138.2	2020-04-02 10:35:55	1	8
276	5	174.6	2020-04-02 10:35:32	1	29
277	32	231.04	2020-04-02 10:35:12	1	31
278	22	444.4	2020-04-02 10:34:36	1	25
288	0.03	317.41	2020-04-17 12:25:00	1	3
290	0.21	2222.23	2020-04-20 20:35:00	1	3
291	1	12.01	2020-05-05 11:27:56	1	28
292	2	44.26	2020-05-05 11:27:19	1	25
293	2	21.06	2020-05-05 11:26:14	1	26
294	13	156.26	2020-05-05 11:25:54	1	28
295	27	193.32	2020-05-05 11:25:32	1	31
296	5	196.35	2020-05-05 11:25:10	1	30
297	14	207.2	2020-05-05 11:24:41	1	9
309	8	344.72	2020-07-02 11:54:35	1	30
303	26	280.02	2020-06-02 10:56:15	1	26
304	26	357.76	2020-06-02 10:55:20	1	9
305	0.24	428.2	2020-06-02 08:35:00	1	16
306	55	424.05	2020-07-02 12:12:19	1	31
307	1	24.86	2020-07-02 11:55:59	1	25
308	20	227.2	2020-07-02 11:54:57	1	26
314	39	493.62	2020-09-02 12:55:00	1	28
316	4	147.96	2020-09-02 13:00:00	1	8
317	1	40.29	2020-10-07 13:05:00	1	30
318	1	7.84	2020-10-07 13:05:00	1	31
319	2	25.04	2020-10-07 13:00:00	1	9
320	13	1055.34	2020-11-12 13:05:00	0	27
321	1	214.5	2020-08-03 10:48:00	1	34
322	1	191.8	2020-08-03 10:48:00	1	15
324	0.0696	221.8	2020-08-06 10:41:00	1	32
323	0.1255	186.86	2020-08-04 10:33:00	1	33
325	0.1192	174.71	2020-10-05 10:33:00	1	33
315	36	385.2	2020-09-02 13:00:00	1	26
326	0.8558	169.66	2020-11-05 14:11:00	1	15
327	1.2466	269.54	2020-11-13 11:32:00	1	34
328	0.0607	191.06	2020-11-17 12:35:00	1	32
329	1.67	19846.98	2020-09-15 14:25:00	0	3
330	0.36	3845.35	2020-09-28 14:30:00	0	4
331	100	20604.98	2020-09-02 14:35:00	1	40
360	1	500	2020-12-28 09:05:00	0	40
312	17	425.34	2020-07-30 12:55:00	1	25
313	33	486.75	2020-07-30 12:55:00	1	9
366	4	132.12	2021-01-05 11:04:51	1	8
367	1	8.12	2021-01-05 11:22:51	1	31
368	0.8679	188.98	2021-01-05 11:45:00	1	15
369	1	16.53	2021-01-12 12:28:20	1	28
370	1	750	2021-01-16 10:55:00	0	40
375	100	10000	2021-01-26 14:00:00	1	40
376	0.0996	182.13	2021-01-27 14:00:00	1	33
379	32	999.04	2021-01-28 13:54:59	1	8
381	0.7243	179.08	2021-01-29 13:50:00	1	35
382	12	93.36	2021-02-01 14:35:18	1	31
383	0.7101	176.18	2021-02-01 16:00:00	1	35
384	0.709	177.62	2021-02-02 13:05:00	1	35
385	2	15.8	2021-02-02 13:20:31	1	31
386	22	986.48	2021-02-02 13:19:24	1	30
387	0.053	180.14	2021-02-03 14:50:00	1	32
388	0.7365	178.09	2021-02-05 14:35:00	1	34
389	85	4469.14	2021-02-08 12:31:03	0	24
390	2.5413	180.05	2021-02-08 12:35:00	1	36
391	1	7.55	2021-02-08 16:18:59	1	31
392	14	209.3	2021-02-08 16:18:23	1	28
393	20	1244.28	2021-02-08 16:17:39	1	29
394	99	1149.9404	2021-02-08 16:17:07	1	26
395	81	1109.7	2021-02-08 16:16:35	1	9
396	99	747.45	2021-02-08 16:15:03	1	31
397	2.4983	178.95	2021-02-09 13:25:00	1	36
398	2.56	181.76	2021-02-10 14:20:00	1	36
406	0.6618	170.88	2021-02-11 11:30:00	1	35
407	2.6141	192.42	2021-02-11 11:35:00	1	36
408	0.8581	180.02	2021-02-12 15:00:00	1	15
411	0.5	499.73	2021-02-17 07:00:00	0	7
412	0.5	494.98	2021-02-17 07:00:00	0	6
413	35	973.35	2021-02-18 11:52:14	1	25
414	0.0554	182.81	2021-02-18 11:55:00	1	32
415	0.33	984.95	2021-02-18 12:05:00	1	22
416	10.5294	179	2021-02-19 15:40:00	1	37
450	1	7.49	2021-02-22 12:41:41	1	31
451	1	54.35	2021-02-22 12:41:22	1	29
452	1	82.49	2021-02-22 12:40:46	1	27
453	5	882.95	2021-02-22 12:40:10	1	10
454	10.5047	181.09	2021-02-22 13:00:00	1	37
455	0.782	179.18	2021-02-23 11:40:00	1	34
456	9.9272	170.65	2021-02-23 11:40:00	1	37
457	0.0865	179.8	2021-02-24 14:30:00	1	33
458	10.4312	179.09	2021-02-24 14:30:00	1	37
459	8	969.44	2021-02-24 14:10:48	1	11
460	0.6936	178.91	2021-02-25 11:50:00	1	35
461	4	29.56	2021-02-25 14:23:11	1	31
462	9	987.73004	2021-02-26 10:19:13	1	12
463	10.6007	174.69	2021-02-26 12:55:00	1	37
464	0.0585	180.38	2021-02-26 12:55:00	1	32
465	2.4472	178.06	2021-03-01 13:35:00	1	36
466	11.3856	187.05	2021-03-02 12:10:00	1	37
467	0.8298	179.39	2021-03-02 12:10:00	1	15
468	0.7316	169.27	2021-03-03 11:40:00	1	34
469	0.0839	172.62	2021-03-03 11:40:00	1	33
470	2.5042	176.19	2021-03-04 11:55:00	1	36
471	0.6691	168.15	2021-03-04 11:55:00	1	35
472	0.1024	299.38	2021-03-05 14:05:00	1	32
473	1.3369	298.66	2021-03-08 15:00:00	1	15
474	1.285	300.52	2021-03-09 12:00:00	1	34
475	1	12.58	2021-03-10 10:30:17	1	9
476	1	39.02	2021-03-10 10:29:13	1	30
477	0.1463	300.42	2021-03-10 11:40:00	1	33
478	1.147	300.38	2021-03-11 11:30:00	1	35
479	1	115.89	2021-03-12 10:57:40	1	11
480	5	883.3	2021-03-12 10:54:13	1	10
481	4.2091	298.13	2021-03-12 15:50:00	1	36
482	18.0914	298.13	2021-03-15 11:40:00	1	37
483	5	75.95	2021-03-16 10:28:26	1	28
484	9	947.07	2021-03-16 10:27:43	1	12
485	1	11.06	2021-03-16 10:30:47	1	26
486	0.096	298.35	2021-03-16 14:25:00	1	32
487	2	83.64	2021-03-17 13:26:47	1	30
488	8	907.2	2021-03-17 13:26:11	1	11
489	1.3295	298.71	2021-03-17 13:25:00	1	15
490	1	8.11	2021-03-18 11:24:37	1	31
491	4	123.28	2021-03-18 11:24:09	1	8
492	5	876.23	2021-03-18 11:22:34	1	10
493	1.2809	298.39	2021-03-18 13:45:00	1	34
494	8	907.12	2021-03-19 11:50:00	1	11
495	0.1521	308.1	2021-03-22 12:25:00	1	33
496	1	31.68	2021-03-22 12:39:04	1	8
497	12	1255.56	2021-03-22 12:38:10	1	12
498	2.5458	176.12	2021-03-23 10:50:00	1	36
499	5	863.15	2021-03-24 10:12:50	1	10
500	9	135.54	2021-03-24 10:21:43	1	28
501	0.6572	175.9	2021-03-24 11:20:00	1	35
502	3	92.1	2021-03-25 13:44:51	1	8
503	8	904.64	2021-03-25 13:43:03	1	11
504	1	14.97	2021-03-25 13:46:27	1	28
505	2	30.64	2021-03-26 11:28:00	1	28
506	10	1033.1	2021-03-26 11:27:23	1	12
507	3	23.4	2021-03-29 10:06:07	1	31
508	4	122	2021-03-29 10:05:22	1	8
509	5	852.5	2021-03-29 10:03:38	1	10
510	2	82.1	2021-03-30 10:44:56	1	30
511	8	919.99	2021-03-30 10:43:46	1	11
512	7	55.23	2021-03-31 11:00:58	1	31
513	9	944.93	2021-03-31 10:59:53	1	12
514	1	8	2021-04-01 10:34:33	1	31
515	1	28.87	2021-04-01 10:34:14	1	8
516	3	125.79	2021-04-01 10:33:48	1	30
517	11	1913.56	2021-04-01 10:33:02	1	10
518	5.0271	342.4	2021-04-06 10:45:00	1	36
519	1	8.1	2021-04-06 10:49:55	1	31
520	66	1002.54	2021-04-06 10:49:22	1	28
521	1	8.33	2021-04-07 14:38:42	1	31
522	1	41.46	2021-04-07 14:38:14	1	30
523	23	953.58	2021-04-07 14:37:49	1	30
524	3	25.14	2021-04-08 11:02:27	1	31
525	35	1000.65	2021-04-08 11:01:55	1	8
526	0.7844	174	2021-04-08 11:05:00	1	15
527	0.0574	190.45	2021-04-09 11:05:00	1	32
528	4	33.36	2021-04-09 11:22:59	1	31
529	13	970.84	2021-04-09 11:08:18	1	27
530	10.2518	169.35	2021-04-12 13:00:00	1	37
531	8	66.8	2021-04-12 13:12:04	1	31
532	8	928.48	2021-04-12 13:11:23	1	11
533	1	8.47	2021-04-13 10:59:15	1	31
534	1	55.5	2021-04-13 10:58:37	1	29
535	17	943.67	2021-04-13 10:58:24	1	29
536	0.6149	176.23	2021-04-13 11:00:00	1	35
537	1	8.66	2021-04-15 10:29:29	1	31
538	77	1031.03	2021-04-15 10:29:05	1	9
539	0.7602	171.36	2021-04-15 10:35:00	1	15
540	1	8.8	2021-04-16 11:33:09	1	31
541	90	993.6	2021-04-16 11:32:47	1	26
542	0.644	167.54	2021-04-16 11:30:00	1	34
543	3	26.82	2021-04-19 10:53:41	1	31
544	9	964.53	2021-04-19 10:53:14	1	12
545	0.0753	173.06	2021-04-19 10:55:00	1	33
546	1	8.94	2021-04-20 14:19:49	1	31
547	37	994.92	2021-04-20 14:19:31	1	25
548	0.052	173.3	2021-04-20 14:20:00	1	32
549	1	15000	2021-04-22 08:25:00	1	40
550	10	89.8	2021-04-22 11:04:49	1	31
551	8	918.4	2021-04-22 11:04:20	1	11
552	0.6038	176.03	2021-04-22 11:05:00	1	35
553	1	11.11	2021-04-23 16:37:33	1	26
554	17	137.19	2021-04-23 16:37:00	1	31
555	5	859.56	2021-04-23 16:36:32	1	10
556	10.6383	179.99	2021-04-23 16:40:00	1	37
557	2.4493	181.05	2021-04-26 12:15:00	1	36
558	5	40.4	2021-04-26 12:14:07	1	31
559	9	952.83	2021-04-26 12:13:44	1	12
560	27	213.3	2021-04-27 11:26:11	1	31
561	100	790	2021-04-27 11:24:51	1	31
562	0.7706	177.64	2021-04-27 11:25:00	1	15
563	1	41.49	2021-04-28 10:45:05	1	30
564	18	956.7	2021-04-28 10:44:44	1	29
565	0.6751	172.39	2021-04-28 10:45:00	1	34
566	0.0533	184.5	2021-04-29 16:15:00	1	32
567	2	83.36	2021-04-29 16:16:01	1	30
568	8	919.12	2021-04-29 16:15:40	1	11
569	2	15.82	2021-04-30 12:08:55	1	31
570	1	115.38	2021-04-30 12:08:36	1	11
571	5	864.15	2021-04-30 12:08:15	1	10
572	0.6148	178.36	2021-04-30 12:10:00	1	35
574	2	16.24	2021-05-03 11:24:51	1	31
575	29	1012.39	2021-05-03 11:24:34	1	27
576	1	1000	2021-05-03 11:30:00	1	40
578	0.0775	184.32	2021-05-03 11:40:00	1	33
579	1	50.55	2021-05-04 16:43:52	1	29
580	9	946.08	2021-05-04 16:42:34	1	12
581	0.7295	180.35	2021-05-04 16:45:00	1	34
582	3	26.4	2021-05-05 14:08:24	1	31
583	1	51.69	2021-05-05 14:07:28	1	29
584	8	918.97	2021-05-05 14:06:53	1	11
585	10.6007	180.2	2021-05-05 14:15:00	1	37
586	0.05458	180.98	2021-05-07 11:25:00	1	32
588	1	3000	2021-05-26 21:00:00	1	40
597	40	0	2021-05-30 11:15:00	2	24
598	1	40.19	2021-06-01 12:22:26	1	30
599	5	525.7	2021-06-01 12:21:46	1	12
600	5	847.75	2021-06-01 12:21:12	1	10
601	0.45194	105.01	2021-06-08 13:30:00	1	15
602	0.09	961.29	2021-06-11 15:20:00	1	23
603	0.94696	285.12	2021-06-14 11:20:00	1	35
604	13	1448.2	2021-06-24 16:52:18	1	13
605	5.62483	194	2021-07-06 10:00:00	1	37
606	5.34308	183	2021-07-21 12:00:00	1	38
607	2	26.54	2021-08-03 15:01:52	1	9
608	9	989.64	2021-08-03 15:01:04	1	13
609	10	1022	2021-08-04 10:50:00	1	17
610	1	10.79	2021-08-27 10:20:41	1	31
611	5	57.05	2021-08-27 10:19:55	1	26
612	15	1618.7	2021-08-27 10:17:01	1	13
613	1	16.18	2021-09-16 13:40:25	1	28
614	1	39.78	2021-09-16 13:39:05	1	27
615	22	2386.9001	2021-09-16 13:38:12	1	13
616	0.83	1687.13	2021-09-14 17:10:00	0	16
617	0.12	1298.46	2021-09-06 12:05:00	1	23
618	1.249	279.99	2021-09-28 19:30:00	1	15
619	10	1085.8	2021-10-08 13:37:12	1	13
620	60	1018.8	2021-10-08 13:35:21	0	24
621	1	39.36	2021-07-23 13:55:00	1	30
622	1	10.99	2021-07-23 13:55:00	1	31
624	0.60641	179	2021-10-08 16:25:00	1	39
625	1	21.35	2021-10-15 10:18:26	1	25
626	5	512.7	2021-10-15 10:18:05	1	11
627	0.07257	246.19	2021-10-28 10:50:00	1	32
628	10	958	2021-11-04 13:05:18	1	11
629	11	1053.18	2021-11-05 14:25:00	1	14
632	1	101.81	2021-11-12 10:25:00	1	13
633	2	179.64	2021-11-16 14:02:00	1	11
638	0.07498	254.01	2021-12-29 12:45:00	1	32
639	1	105	2021-12-29 12:50:00	1	13
640	1.61888	171.02	2022-01-04 12:00:00	1	42
643	0.09831	249.95	2022-01-25 13:40:00	1	33
646	2	2248.84	2022-02-02 14:15:00	0	18
647	1	1162.78	2022-02-02 14:20:00	0	19
648	19	2252.43	2022-02-02 14:30:00	1	43
649	10	1044.1	2022-02-02 14:30:00	1	13
650	0.09	1008.17	2022-02-02 19:00:00	1	23
653	4	455.58	2022-02-18 14:49:12	1	43
658	1.35168	277	2022-02-23 11:36:00	1	44
659	1	111.6	2022-03-03 10:21:27	1	43
660	1	2451	2022-01-20 06:05:56	0	40
661	1	4500	2022-02-08 11:10:12	0	40
662	1	7000	2022-01-04 09:25:26	1	40
663	3	327.9	2022-03-15 11:40:26	1	43
664	0.06695	195.19	2022-03-15 15:28:00	1	45
665	1	111.28	2022-03-18 19:30:13	1	43
666	2	30.2	2022-03-29 11:02:14	1	28
667	1	104.14	2022-03-29 11:00:52	1	13
668	8.11043	294	2022-03-29 10:58:00	1	37
669	1	103.75	2022-04-04 15:49:39	1	13
673	1	119.05	2022-04-08 13:14:21	1	43
674	0.09	1028.33	2022-04-04 09:45:51	1	23
675	1	97.91	2022-04-14 15:27:11	1	11
676	2	205.96	2022-04-14 15:26:51	1	13
677	2	236.8	2022-04-14 15:14:42	1	43
678	1.11594	305	2022-04-26 14:48:00	1	34
679	5	499.65	2022-05-05 11:25:51	1	13
680	1	116.2	2022-05-13 10:07:13	1	43
681	2	232.4	2022-05-13 10:05:01	1	43
682	5.48183	190	2022-05-16 16:41:00	1	38
683	1	114.95	2022-05-25 16:33:29	1	43
684	1	1100	2022-05-27 17:20:09	1	40
685	0.00119476	187	2022-05-29 16:15:48	1	46
686	4	463.16	2022-06-02 10:10:27	1	43
687	0.09	1047.71	2022-06-02 20:05:49	1	23
688	16.34817	0	2022-06-11 10:00:20	2	32
689	1.27205	0	2022-06-11 10:10:00	2	45
690	1	114.69	2022-06-13 13:06:43	1	43
691	1	114.86	2022-06-14 14:51:40	1	43
692	1	99	2022-06-15 13:52:41	1	13
693	29	3320.5	2022-06-15 13:51:54	1	43
694	20	3264.8	2022-06-15 13:50:38	0	10
695	1	99	2022-06-17 10:25:43	1	13
696	42	4166.4	2022-06-17 10:25:06	1	13
697	45	4265.55	2022-06-17 10:23:53	0	11
698	0.1	30000	2022-06-17 10:50:12	0	40
699	2.56	29959.88	2022-06-17 11:25:59	1	47
700	1	115.33	2022-06-24 15:17:39	1	43
701	33	3805.89	2022-06-24 15:17:07	1	43
702	40	3850.06	2022-06-24 15:16:05	0	12
703	0.01272254	1400	2022-06-28 12:55:51	1	46
704	1	115.12	2022-07-08 13:31:03	1	43
587	204	0	2021-05-17 08:55:00	2	29
623	8	897.32	2021-07-23 13:55:00	1	13
577	60	0	2021-04-28 11:35:00	2	27
634	10	867.95	2021-11-26 10:05:00	1	12
651	1	105.17	2021-12-22 13:45:46	1	13
644	1	105.8	2022-01-25 13:50:00	1	13
641	2	209.6	2022-01-19 17:35:00	1	13
705	1	91.75	2022-07-08 13:33:34	1	12
706	0.08879	203.99	2022-07-08 16:30:22	1	41
707	3	355.38998	2022-07-18 10:20:21	1	43
708	20.21999	0	2022-07-24 11:50:14	2	33
709	2.80147	0	2022-07-24 11:55:05	2	41
710	1	95.27	2022-07-26 11:06:44	1	11
711	0.00476211	600	2022-07-29 13:15:59	1	46
712	1	119.23	2022-08-08 14:50:03	1	43
713	2	244.3	2022-08-15 13:08:46	1	43
714	6	47.76	2022-08-15 13:19:32	1	48
715	0.08	951.56	2022-08-03 16:20:53	1	23
716	8	65.36	2022-08-25 14:12:51	1	48
717	0.01	800	2022-08-29 09:45:27	0	40
718	55	457.6	2022-08-31 13:17:08	1	48
719	0.72645	186.54	2022-09-02 10:35:49	1	39
720	1	127.13	2022-09-09 13:33:42	1	43
721	2	16.58	2022-09-15 10:11:51	1	48
722	3	282.09	2022-09-15 10:11:34	1	13
723	6	50.22	2022-09-26 14:43:06	1	48
724	3	287.4	2022-09-26 14:42:41	1	13
725	9	75.51	2022-10-04 14:00:54	1	48
726	8	732	2022-10-04 13:59:07	1	13
727	9	1134.23	2022-10-04 13:58:38	1	43
728	29	959.61	2022-10-04 13:56:16	0	27
729	23	963.7	2022-10-04 13:54:23	0	8
730	0.001	200	2022-10-07 14:35:21	1	40
731	2	249.4	2022-10-10 10:30:53	1	43
732	3.01241	301	2022-10-11 14:55:00	1	49
733	8	69.2	2022-10-14 13:39:40	1	48
734	1	94.98	2022-10-14 13:39:11	1	13
735	10	85.9	2022-10-17 14:04:32	1	48
311	6	94.14	2020-07-30 12:50:00	1	28
737	0.1	6597	2022-10-21 08:25:29	1	40
738	0.09	1095.45	2022-10-05 18:35:19	1	23
739	0.08	980.27	2022-10-24 18:35:34	1	47
740	0.04	492.23	2022-11-04 17:05:07	1	47
805	2	177.36	2021-11-29 10:50:00	1	11
806	1	8.11	2022-01-03 00:00:00	1	31
807	2	18.5	2022-01-03 00:00:00	1	26
808	2	208.68	2022-01-03 00:00:00	1	13
809	0.08	1033.09	2023-04-04 08:55:28	1	55
810	3	23.37	2023-04-24 16:10:13	1	48
811	5	486.29	2023-04-24 16:09:46	1	11
742	3.05	191.05	2022-11-04 10:50:16	1	50
743	9	74.79	2022-11-09 14:19:07	1	48
744	10	1044.4	2022-11-09 14:18:46	1	12
745	10	949.8	2022-11-09 14:18:12	1	13
746	24	989.2399	2022-11-09 14:17:42	0	27
747	23	976.12	2022-11-09 14:16:46	0	8
748	1	126.65	2022-11-09 14:15:28	1	43
749	2	246.92	2022-11-16 10:13:02	1	43
750	14	113.12	2022-11-28 10:37:33	1	48
751	4	31.64	2022-12-13 15:27:25	1	48
752	3	295.38	2022-12-13 15:26:53	1	12
753	0.1	3000	2022-12-07 10:30:44	0	40
754	0.04	497.58	2022-12-07 18:25:06	1	47
755	0.08	994.19	2022-12-05 19:25:23	1	23
756	7	55.86	2022-12-15 13:50:35	1	48
757	2	192.16	2022-12-15 13:50:02	1	11
596	56.4805	0	2021-05-27 11:05:00	3	37
758	10	81.7	2022-12-29 10:41:00	1	48
759	2	242.56	2022-12-29 10:40:36	1	43
760	0.08	1004.82	2023-01-04 10:20:23	1	47
761	8	63.84	2023-01-12 14:12:21	1	48
762	1	120.13	2023-01-12 14:11:44	1	43
763	1.61444	181.78	2023-01-05 14:15:42	1	51
764	2	15.98	2023-01-17 14:03:39	1	48
765	1	99.37	2023-01-17 14:03:21	1	12
766	1	93.17	2023-01-17 14:01:55	1	11
767	1	89.2	2023-01-17 14:01:34	1	13
768	11.09414	2473.59	2023-01-17 14:25:58	0	15
769	19.40347	1300	2023-01-17 14:25:54	1	52
770	9.75678	1191.69	2023-01-17 14:25:36	1	49
771	0.1	2192	2023-01-11 10:20:16	0	40
772	7	56.98	2023-01-25 10:22:09	1	48
773	0.1	598	2023-02-02 09:25:20	1	40
774	0.55	6952.45	2023-02-02 09:30:54	1	53
775	21	167.79	2023-02-08 11:13:40	1	48
776	0.08	1012.86	2023-02-02 11:20:02	1	54
777	8	1126.8	2023-02-08 11:30:35	0	36
778	9.12424	612.68	2023-02-08 11:35:17	1	52
779	3.95681	514.12	2023-02-08 11:35:53	1	49
780	117	930.15	2023-02-13 13:44:13	1	48
781	12	1089.84	2023-02-13 13:42:34	1	11
782	13	2079.22	2023-02-13 13:42:07	1	10
783	26	1007.24	2023-02-13 13:41:36	0	27
784	90	1076.4	2023-02-13 13:40:55	0	9
785	30	1020	2023-02-13 13:40:02	0	8
786	26	1001.52	2023-02-13 13:39:17	0	30
787	2	16.02	2023-02-22 16:31:29	1	48
788	1	97.96	2023-02-22 16:31:08	1	12
789	1	160.37	2023-02-22 16:30:30	1	10
790	6	47.82	2023-02-28 17:00:09	1	48
791	0.1	700	2023-02-28 12:25:25	0	40
792	0.1	1360	2023-02-20 17:25:20	0	40
796	9	71.37	2023-03-15 10:19:43	1	48
797	3	480.54	2023-03-15 10:19:10	1	10
801	0.1	400	2023-03-22 17:35:56	0	40
798	0.1	600	2023-03-14 08:20:24	0	40
799	0.1	250	2023-03-18 08:20:52	0	40
795	0.1	360	2023-03-11 18:10:00	0	40
794	0.1	550	2023-03-09 18:10:23	0	40
802	7	55.02	2023-03-28 14:11:59	1	48
800	3.08338	189.75	2023-03-06 10:00:00	1	50
793	0.08	1022.59	2023-03-06 13:25:24	1	53
803	0.08	1033.09	2023-04-04 13:50:20	1	53
804	8	126.8	2019-09-10 09:45:00	1	9
242	40	595.6	2020-03-03 13:45:40	1	28
812	7	53.97	2023-04-26 16:22:59	1	48
816	20	200	2023-05-23 09:55:35	0	48
817	7	0	2023-06-21 20:05:11	2	48
818	7	0	2023-06-21 17:05:07	3	8
836	100	10000	2023-06-25 12:10:56	1	14
838	100	0	2023-06-25 12:20:06	2	14
839	15	1500	2023-06-25 12:25:28	0	14
840	100	0	2023-06-25 12:30:56	3	14
841	13	1274	2023-06-25 12:35:33	1	14
837	10	1100	2023-06-25 12:15:43	0	14
\.


--
-- Data for Name: operacoes_import; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.operacoes_import (id, investidor_id, arquivo, extensao, tipo_arquivo, hash_nome, data, lista_operacoes_criadas_json) FROM stdin;
1	1	Exportar_custodia_2022-02-17.csv	csv	NU	a509f3583497bd68bc78563c2a68c65d1da37dc9c7084601b1bcb2a18795aa01885a8e4b86ccfa2e9f8dc0279b1b6cd1c6972a167d6886beb646ccc8e11583d4	2022-02-18 19:00:54	null
8	1	orders-2022.02.18-14 49 20.csv	csv	Operações Clear	b74b928ba5c3537af2afef58b7fe7a7fbb821f4ab23001574e177f80c821f6724c28c87a5e37a3de510952afdd2ebb2b60e95f56b6416142655e87e577c796fd	2022-02-18 19:19:54	{"operacoes_id":[653]}
11	1	Extrato de Investimentos Simplificado.pdf	pdf	Operações Inter	9fe8e6f6dfd8e32e28dd0fd82ebb2115c730f7a65184e708ab7997bf48d95f8dd9ccf32f796fb5e4df7fc3f940393afc6c4661cc6e509bdd1cba720ba277daa9	2022-02-18 20:00:29	null
13	1	report-statement-BR_2022_02_23.csv	csv	Operações Avenue	a2fe06cd4bc57571bc9d5c1515e150bb1d93f073730d5d6c3dd2392d283fea4a23849aada7f06598aa853eb855444d4825c7535035f1f5763443a33a5806f861	2022-02-23 18:56:50	{"operacoes_id":[658]}
14	1	orders-2022.03.03-10 22 09.csv	csv	Operações Clear	d0bb2cfa81ccdfdc47e3d2f854de88203a4e5744bfb0f0b4749e98b952be4675214cd56c155f647ef1479b831738df7d730ba4e3c17fa63fe271e9abbd101076	2022-03-06 10:57:25	{"operacoes_id":[659]}
15	1	orders-2022.03.15-11 40 32.csv	csv	Operações Clear	aab95fce177212ba6d1d9f9989e138fa8b4401a796afb9e74f80e9558f348df8de4a136728b66091a256a3e278c8c1d2b5863e43fdd1aec8d693b503af213066	2022-03-15 21:24:56	{"operacoes_id":[663]}
17	2	avenue 03.22.csv	csv	Operações Avenue	3832979fe9328904d9b6b07d6de298ab0d37a8e960c49180013782317fda02481c05a5af06eaad17578515c7416dec020ef5454791c017b4368a5746196dff39	2022-03-15 21:42:56	{"operacoes_id":[664]}
19	1	orders-2022.03.29-11 02 50.csv	csv	Operações Clear	302137704b5be31ab3f24958e4225b24257762da99288e7febfb1ca92a37bc8afdc4e76bef1482d3e979224f58b07ede203645d9c7d89094ef50fe11b23de74a	2022-04-02 10:53:45	{"operacoes_id":[666,667]}
20	1	report-statement-BR.csv	csv	Operações Avenue	048525bfa7e389da5b4a129f3a9fa7ac6e97e78d6761a54e63c6169c58ab0b94e19bac2d18fa7d48dc19a75a6a84e413a49fe5287526b87ee46f7e70011476e3	2022-04-02 10:58:46	{"operacoes_id":[668]}
21	1	orders-2022.04.04-15 49 51.csv	csv	Operações Clear	e74201a56733f21fceff2eaa76fe99f5c9df0606178540c21ba9e75723d080eb0ffdd7b288e51e956a104f72d5bb3e0de03a1a1eace74d7d14b9f930a793d0d9	2022-04-04 20:22:32	{"operacoes_id":[669]}
22	1	Exportar_custodia_2022-04-04.csv	csv	NU	fef8fc17ccb4249c073e487f0aa856346278e75b1c7397566e7542a542428ec7d7d65a6ea812a64a7722c60d4c392dc56cbb79495e9509b1e46bf037ff1b009d	2022-04-04 20:25:35	null
26	1	Extrato de Investimentos Simplificado.pdf	pdf	Operações Inter	1ed2b8528fe23739635be49e4b4108a0a4671a8e8c1d6fdfc719b63616ead606509c3457561f5b1a06c00a29c9def46f5ee8d5f3b345299e34f7d22f62ac9ebe	2022-04-09 09:32:39	null
27	1	orders-2022.04.08-13 14 26.csv	csv	Operações Clear	ef8328bae355db607b12cbf406e3b2fb9a48c3f95fd52b91db2df92661ce9b8e832781f54ed2a97e89948c25e7e68d8b36e7c3704efe1b22300c54e594c8decd	2022-04-09 09:35:14	{"operacoes_id":[673]}
28	1	orders-2022.04.14-15 28 02.csv	csv	Operações Clear	da255612437a9cca007f3ad0342a0bdaed845cd27c6806e1d20385e78a6dbf4d923add7fe1c31432b29cdbefa6b4d2bc6513c2795cb5ba0d93f903bda9c38714	2022-04-14 15:31:11	{"operacoes_id":[675,676,677]}
29	1	report-statement-BR.csv	csv	Operações Avenue	0e61c777bc63be0bca5315e7f7cb9bb5b625afc7470497337745929d03cd94c299dc30d43e41a4b6738975f9034326c2590419caa79903938d505c8ab00b2ca1	2022-04-26 20:27:51	{"operacoes_id":[678]}
30	1	orders-2022.05.05-11 26 20.csv	csv	Operações Clear	f0e52b16ee60b437ace613b84e3a19fc76ea1210a9d207008103244727eeb862c25b746c73b7bfc96d8fd7686d2a9341a5ab2b1d7bc2a9f53de3b3134a5be2f6	2022-05-05 11:27:22	{"operacoes_id":[679]}
31	1	orders-2022.05.13-10 07 29.csv	csv	Operações Clear	b2271b17b44056fe0a5a7e51cbd8bbc40cf82ec9f5855f3d68ec43fef5e8bb800de2318997db24dc0bdbc04eb29bc1c27fab26380d9efdf04f10e4682ff046eb	2022-05-13 10:08:15	{"operacoes_id":[680,681]}
32	2	avenue 5.22.csv	csv	Operações Avenue	390d8d2654973be8339277e599aae264fdf3bc5fdb57ce538cdd0161d51d9be5ceda6c47cbf9a6d09540b4cae9d6d1b77540eac1f9988e8a8728433841621fc5	2022-05-18 18:15:00	{"operacoes_id":[682]}
33	1	orders-2022.05.25-16 33 36.csv	csv	Operações Clear	ce09df65ec96d0e85e6b7fc1e8addd8c1d7451b60236a3920e2c678399df964d4de9f432885dc8ae3b1a01fd0ffe1b44fdf1dc95fb26de9f931aaff5234b8c06	2022-05-25 16:36:24	{"operacoes_id":[683]}
34	1	Extrato de Investimentos Simplificado.pdf	pdf	Operações Inter	d74c1187892217e78a981fd62514d98d8fa995b9dc0657efd6e1749d21ebf878192cd41e5037ab6da440739b79804a0c91bf01e19003352897d533f81eb8899d	2022-05-27 17:40:02	null
35	1	orders-2022.06.02-10 10 38.csv	csv	Operações Clear	0ca54e4c8d4968f291cdc0ff44f884895a82905e0cd0e86e771d8540231007d0f633a545306dcd5e696372be0656f1466db8f8013e969e2e81b5ab5c77ea19fa	2022-06-02 11:22:58	{"operacoes_id":[686]}
36	1	movimentacao-2022-06-05-19-50-57.csv	csv	Proventos	ff7011152add929517bb2d19b1175c70ba0070c5d4dc6b7ba683ebcea0e9387ec4eb20a89d3a508d4814322ce143bb20007bafcace78f5a39dc4594e12de408f	2022-06-05 19:53:58	{"operacoes_id":[184,185,186,187,188,189,190,191,192]}
37	1	orders-2022.06.13-13 06 50.csv	csv	Operações Clear	8f99c43507161fd0983c9934fcc626dac47b86e33e107703d3d91a0d6dfca6d630fbd89480195d0afec153b3227311ae54627dd64a2807f097abe33145c0c54b	2022-06-13 13:21:21	{"operacoes_id":[690]}
38	1	orders-2022.06.14-14 51 51.csv	csv	Operações Clear	f2a13acf3cc11f2dc1958e7f8df4a300b59e75d41c2936c34f06ca979bfc06c42586d2084e62df4fbb2bad4c84b36ab8486780db6bed0c536afdbba110e01cbc	2022-06-14 14:54:45	{"operacoes_id":[691]}
39	1	orders-2022.06.15-13 52 53.csv	csv	Operações Clear	55191455aebd360e737b71eab4f0a86a31b737761abdccfcda562ca8ec4406457f716289f3b744a238ee13f089d20bb334778f640a6df5dff901d25f01bd774d	2022-06-15 13:54:55	{"operacoes_id":[692,693,694]}
40	1	orders-2022.06.17-10 26 00.csv	csv	Operações Clear	daaa6a9de68e3d2b3cda190d00621db112041a9cda9331157b6ade0e1d9aa6a85cac1c2e4c06420506ce913735138baed84cf11db3f711b4fce71b1a925d16f0	2022-06-17 10:26:33	{"operacoes_id":[695,696,697]}
41	1	Exportar_custodia_2022-06-21.csv	csv	NU	374a3289c59e2fac308d0a210699d04515336f92a329bca9f7fc42162e3403a1210b8a49531da0a39837d98e4f78fff29b75772e4b27c00f991fca8b6dd4ea88	2022-06-21 10:23:18	null
42	1	Extrato de Investimentos Simplificado.pdf	pdf	Operações Inter	037f492f8439eb91acda1609273aafeeeef3e48c430e192707fde1fc5588884a2e67b02d646ec965f2cc8e04ad2b5dfdd00c9b0bcefaf6f3a42bb3af3ae36be3	2022-06-21 10:27:40	null
43	1	orders-2022.06.24-15 17 46.csv	csv	Operações Clear	774a87d0869cb2e2e3df21830c439add23b726176f1e1214424cb6c026dc725522ab953ac9aeb1cbca1d3dc9bdcb799eebcf827200cf222a1fd3e60992fa3dc5	2022-06-24 15:18:13	{"operacoes_id":[700,701,702]}
47	1	proventos-recebidos-07-2022.csv	csv	Proventos	245c88b91a70e9e6339dd3c5e69e3c03f12130225e866eaed693c653b84b68ffab2a28604e04e60a5c666b1c9f61b8f9f84c82c6b7f2e2700564c961aea51eb3	2022-07-01 15:40:21	{"operacoes_id":[193,194,195,196,197,198]}
48	1	orders-2022.07.08-13 31 37.csv	csv	Operações Clear	11a19e2ab659a485ba18e63afae4a0e199f4bc13462df799d2e594b9c69c901b15d1e173d290822eb212878d12a9666b99aae46eff69eb8d7cb8114daeb28220	2022-07-08 13:32:18	{"operacoes_id":[704]}
49	1	orders-2022.07.08-13 34 04.csv	csv	Operações Clear	534558601d9e0b29f8221267f8641b748dc0ed11d810b2788d5fe1b0936d6ea6be84990b1d579ad3a1f3a9e59bca880e8291851bf7e4152efc01ec733cfd51f5	2022-07-08 13:34:31	{"operacoes_id":[705]}
51	1	orders-2022.07.18-10 21 01.csv	csv	Operações Clear	7bf6e8e59024e432018e94cd0f7186dbb9f3531d4d4fc79a5d2d4dbb916abdb80bd2786a53230ce9fe005e7e8cb53da6e2c9003649c179290c9b8e49b3b42a40	2022-07-18 10:21:46	{"operacoes_id":[707]}
52	1	orders-2022.07.26-11 06 50.csv	csv	Operações Clear	2c2ebbd42cb099796be99c912baeb988a7a6035376ce403b6608294b95aae379c5bf77fc5a4c4e9ddee6e5fba235b4fff6e46407d711ab664a654b1a7317c9a3	2022-07-26 11:07:52	{"operacoes_id":[710]}
53	1	Exportar_custodia_2022-07-29.csv	csv	NU	f12d8341ea90a6cad5621e4afbd61f37cd481ab358fb8fab67c782d7a04af668af4d326cae4bf6e3f1a231ea5f55741e4f1ad92a555e2d059e9fedf7ee436b1e	2022-07-29 13:22:30	null
54	1	proventos-recebidos-2022-08-01-08-25-17.csv	csv	Proventos	83062647b88a653b6f71788f5948036f309c8d6246718a3677a97dba254542421e9429b03cb31e819b01ea572b82d8894bc90feca773ee9c9b83b276efd6d993	2022-08-01 08:27:28	{"operacoes_id":[199,200,201,202,203,204,205,206,207,208]}
62	1	orders-2022.08.31-14 27 51.csv	csv	Operações Clear	c093da3de3fee1c3e3e6ac33630a9dbe3fb22d52ccf6c059c6492fd552fe714e9c4bfedee9bda0d190ebf328806ba8708aeb99a61eef335672dd16d534f54b31	2022-08-31 14:29:16	{"operacoes_id":[718]}
56	1	orders-2022.08.08-14 50 12.csv	csv	Operações Clear	f0c3c74cd674da354318cdf2b30c0eb1d5b5b7d13a9a9c5ae9759e2c2f400cc8ded5826139854c53816585de51600dfdf68be349b78fcf91771f7d933998a690	2022-08-08 14:52:22	{"operacoes_id":[712]}
57	1	orders-2022.08.15-13 08 52.csv	csv	Operações Clear	8feb18d4bd4a92357d9b74504e7c2d1a89b80eb02408ab7f060e910bc1f6eb2229371478f31f59eedf5ceba1ac140712cf6ab574f76851b6cec914cdaf2762aa	2022-08-15 13:10:30	{"operacoes_id":[713]}
58	1	orders-2022.08.15-13 20 06.csv	csv	Operações Clear	2a14bd4c956b7778802223a9c64e507eb282788a16e3a24ca5ed7fdb7dca7440ebed8f343a94bae3d1e842d49c594c026735b343e34345a2a5a6df71d7969b11	2022-08-15 13:22:16	{"operacoes_id":[714]}
59	1	orders-2022.08.25-14 12 58.csv	csv	Operações Clear	05af18631d94d2291bbcc9ea1c92384590f819fdef9c6ecef19225c0338ee98e414a0325e1696c4c47f5a6e7cdaa950c7bdfa4ee514353ff6c602ede74ca5c1d	2022-08-25 14:14:32	{"operacoes_id":[716]}
61	1	proventos-recebidos-2022-08-29-09-51-23.csv	csv	Proventos	25f609439cc722cabfe3d08ebcf23f9f5fe876e6fe18276895f2ff52cc6525422ddb148d15778b076bfc9fad82e8ee1e0a90a29cd0288a6ad94dc5fc1141c244	2022-08-29 10:20:10	{"operacoes_id":[212,213,214,215,216,217,218]}
70	1	orders-2022.10.10-10 30 57.csv	csv	Operações Clear	94dd4c6e612085c9063b5ee694489eeb52d70307f9d00dd74e1408e8efd31a0740ce027d169aef5cfa59f9baa8f7932251949439e568b29c19e2591df0ee9c39	2022-10-10 10:32:09	{"operacoes_id":[731]}
64	1	proventos-recebidos-2022-09-01-12-35-19.csv	csv	Proventos	5d70cb61263325c21c3432f71094e6f1ae0d3c50c1eea5aa44cb9993e14b438040a3e9fd88938f54c4a7926d438fae1afb00525f5d4b1899e71b9d6e55bbc4f5	2022-09-01 12:40:06	{"operacoes_id":[219,220,221]}
65	1	orders-2022.09.09-13 43 08.csv	csv	Operações Clear	736df08747c8ded9ec0003576c9019856f4861d80986f2ab69429c193669aed65768ee63b3edd6f8f3145e4afd109b4f3f9185812e3e39f5e2fe8332c7036629	2022-09-09 13:46:25	{"operacoes_id":[720]}
66	1	orders-2022.09.15-10 13 38.csv	csv	Operações Clear	2fe0653041e84bd1818e24db041e8fbf8ac7bfab8b29c8a2811b598b353568e1b69355024d302673d852c9f85bd153a26d29a6b1b82abf59ef875bccc719db71	2022-09-15 10:16:46	{"operacoes_id":[721,722]}
67	1	orders-2022.09.26-14 43 22.csv	csv	Operações Clear	13758b4ff1c2967d30faa4cc370fbb8b485bbaa016ac7f0dd27da4cdcc68c6974f58fef2f3d6ac65f462283153badb2e758b5120b8c55b1e0148d6237a8c30d7	2022-09-26 14:45:15	{"operacoes_id":[723,724]}
68	1	proventos-recebidos-2022-10-03-22-31-45.csv	csv	Proventos	923f9ce384bd7de9579064050feaeeb1e06e834a5111c56b8027cc8bba0ada8a8826799cfc4d4b6cb851308d26a54e75c0af25f2016a50cd4fcce7f25e4325be	2022-10-03 22:34:52	{"operacoes_id":[222,223,224,225,226,227,228]}
69	1	orders-2022.10.04-14 01 38.csv	csv	Operações Clear	61e365f8b546a2b59e5f8f90ca6f62ad31ef05698858fc659b54f74b6259941189449e4870e80a5c9f3256998de02f7e45f3c7467f0f9a1221b087bfa12ac9c6	2022-10-04 14:02:11	{"operacoes_id":[725,726,727,728,729]}
72	1	report-statement-BR.csv	csv	Operações Avenue	b4da9170257ab509bc6d8ed7207f6006f51a658f362f131a3c4c4697a5ac486125a51e27d8bd49dbf23b0da79158de304f8f8f2ad3c90008d97864ce29d182f6	2022-10-11 15:06:55	{"operacoes_id":[732]}
73	1	orders-2022.10.14-13 40 00.csv	csv	Operações Clear	3cc28b268edb3ba3a96796d8543af0e397171eada9b96742ccaae983488bfc41675249d2d9b83b236e55b4e2d9ee1cd34bb62a775a3fc8910bbf22abdcec89da	2022-10-14 13:40:22	{"operacoes_id":[733,734]}
74	1	Exportar_custodia_2022-10-15.csv	csv	NU	fa3b2c1fd85e8f3b84eff42509215ecedfc691d67605130b88f405db6cd3618d07f63e612cb35468910b734ad44e760cbd0766f6d3b58c812d46319d49816f90	2022-10-15 16:15:55	null
107	1	orders-2022.10.17-14 04 39.csv	csv	Operações Clear	b915051a98c20230bb483d3ad48177bac3e9e8877fc70aa9531c28e38dfb636456010f6ad8c1099f8d9308ff7a1f77e5e51f0165d555dd65b3adb62c6ce9f376	2022-10-17 14:07:11	{"operacoes_id":[735]}
113	1	proventos-recebidos-2022-11-01-18-03-10.csv	csv	Proventos	fe8a6177363062da16b13bf9b7978a8172d5c9b5596ae29c91d0a9b7f666df2a3ea475bd88e5a43b26d73d6a5a07952d3a243d6217848e02fe2e06c53f0f6f64	2022-11-01 18:18:19	{"operacoes_id":[265,266,267,268,269,270,271,272,273,274]}
114	1	Exportar_custodia_2022-11-01.csv	csv	NU	9a371eb39d61a480b60081a25757e80dcb6cdeb032ec5c6bbdc7521e8c5676409766f50f3688b20dcbb953eb85a19fb5d628d6aed3aab9eebb0e6630a40e6727	2022-11-01 18:28:45	null
115	1	orders-2022.11.09-14 19 24.csv	csv	Operações Clear	fd951c353d71ccc9e75e4e6860f83d052d64b33030a9c87c2d2381b0f9ca819f0c50b4915eae49ce58192d679df851eb093ee65785502f5e469da89f5aad5fe7	2022-11-09 14:20:51	{"operacoes_id":[743,744,745,746,747,748]}
116	1	orders-2022.11.16-10 13 18.csv	csv	Operações Clear	088695269ca135c00c5efb2a6a0c252bcec20d9c45d1c2015a1170bb847d3fe576c11ca1070dc82e69495191dce248888e4dd571baf71a1d806e214c53b344cf	2022-11-16 10:19:59	{"operacoes_id":[749]}
117	1	orders-2022.11.28-10 37 40.csv	csv	Operações Clear	e1e84cb8fc6dfccf689864b0841bdd53a01576fed2cf61944accce6f05b8314626a1ff14560d42601e196ad20525f5df94672ffa0e3e4b23b8260de6bd2c1564	2022-11-30 08:35:49	{"operacoes_id":[750]}
118	1	proventos-recebidos-2022-12-01-13-22-40.csv	csv	Proventos	dab1a483d9990edeb7c412172a3fde2bfef1987ed4e892e86ae5858aafb25cbc45a8ba3e4fd868af5e651e55590eb3b0188d48d68a4bbeb31a03e94833c845b8	2022-12-01 13:24:37	{"operacoes_id":[275,276,277,278,279,280,281,282]}
119	1	orders-2022.12.13-15 27 41.csv	csv	Operações Clear	73109f6d07cda834282438d3d02445900025f932e938f6ba8adca18c4c66a17a665c65e10b40bf74edffd0f5a20418c9ff3db455536c527f710345307c6a4985	2022-12-13 15:32:04	{"operacoes_id":[751,752]}
120	1	orders-2022.12.15-13 50 59.csv	csv	Operações Clear	23950a9dbbfad91dd74ee7034cee357d409c833c84c99baffba5a9255e1e41aea39a4945c0e64246d47a133424cc5971f5a221725b44bb518f95cc7536f4b52b	2022-12-17 09:25:48	{"operacoes_id":[756,757]}
121	1	orders-2022.12.29-10 41 16.csv	csv	Operações Clear	1083b299becc98344906e2389a24aca225f1fb9e75e3961d046941d0d52079348c0e9eb703a991cf8cd42f4879944948620e1ae0721778f911f3331c6dce693d	2022-12-31 16:56:01	{"operacoes_id":[758,759]}
123	1	proventos-recebidos-2022-12-04-a-2022-12-31.csv	csv	Proventos	36d03928738f7df5c1656ab06bc715d98f7055c51dc267bf02946feaffaf685b30d605387202b2be21d7d83c9de20a951480d5f81aeb99232a63db2f38aea791	2023-01-04 14:50:23	{"operacoes_id":[288,289,290,291,292,293,294,295,296,297,298,299,300]}
124	1	orders-2023.01.12-14 12 41.csv	csv	Operações Clear	ac55b81ebc0430ec61e8fe3a052e8d082b709ef98904aef6df3239098e14dcecd52740d79c566296169cc8eb1db329b1c9564f860f30f387bad3d5c41101f178	2023-01-12 14:14:43	{"operacoes_id":[761,762]}
125	1	orders-2023.01.17-14 04 49.csv	csv	Operações Clear	8cae3bf6184fd610d189aea41148b08cde50db302304f9f33216e9f21daa6562611a8d5bc4995e5bbf8edb65a2d0f6b9693889700c5b96b82de4acafbce05302	2023-01-17 14:07:18	{"operacoes_id":[764,765,766,767]}
134	1	orders-2023.02.28-17 00 17.csv	csv	Operações Clear	30c05893408d6ebc949fafdb4cf6d40549b89dca0ec3b0db440b436f6fde1c6ab75012f2ffad18b253eabe722ac212b343f9577168a02a5dcc8f5c12c01322af	2023-02-28 17:27:58	{"operacoes_id":[790]}
128	1	orders-2023.01.25-10 22 14.csv	csv	Operações Clear	4a2f48ccae50c0a4eef78c9c2967f256e9396a1e8be29a355a8ea82e4d652cbf7e0a89feca72c87414b715a99ee2a6bd2ba4c79cc05a872365c037e5ba203ff3	2023-01-25 10:27:15	{"operacoes_id":[772]}
129	1	proventos-recebidos-2023-01-04-a-2023-02-03.csv	csv	Proventos	dd15abd16ca3c75952bab9c2b154f21e8bfa6aec7db803c3564aa354e6fd6aa39e65ee09f33e2599d54973adf1892067e44ce1aed7d58453b9adfff433845ded	2023-02-06 20:35:26	{"operacoes_id":[301,302,303,304,305,306,307]}
130	1	Exportar_custodia_2023-02-06.csv	csv	NU	1e0634da1316c6c6c8b70eef49c06a51018b8baf231121a6b58e56fade3a1f04154e02ac7e0e9211efb082837f4c65e2ff547061d27773f13c24b99192a5d410	2023-02-06 20:45:56	null
131	1	orders-2023.02.08-11 15 45.csv	csv	Operações Clear	d983194c0bb2dc0dc4c56d3c0d730d22a320de353a181fe93ec5a81bbff2d2e3d28a1b00ab5fbef63b43542a73f525725930de98be2513556430fb070d4c826a	2023-02-08 11:17:10	{"operacoes_id":[775]}
132	1	orders-2023.02.13-13 44 22.csv	csv	Operações Clear	463f4f28ceebfff0e2fd7ea17528e20a8e52f0bd2295ec3f000b595f6e897f2a31926f59ff81875547d7db9e03cf1297470ed7b5866a1bd9d7b437d23787ae78	2023-02-13 13:45:22	{"operacoes_id":[780,781,782,783,784,785,786]}
133	1	orders-2023.02.22-16 31 40.csv	csv	Operações Clear	eb022a69bbbb9e07ed4fa8d32894189458e409fdb97ff2e5d8c3c3d3e9b8b33965e69cf2857ddbdfe597c70e408f2160ba4bcda69054fd90407bbf206b5a0313	2023-02-22 16:32:51	{"operacoes_id":[787,788,789]}
136	1	proventos-recebidos-2023-01-28-a-2023-02-27.csv	csv	Proventos	ceaee077a5d76271801928a51a2062ccd7cc69b315bd0981b5940d2549a8ce435164a83433f7874fa0f94377191a4adbc6616e43be05891f0ed971e5060e1c8a	2023-02-28 17:56:50	{"operacoes_id":[308,309,310,311,312,313]}
137	1	orders-2023.03.15-10 20 10.csv	csv	Operações Clear	f9259d1f7a0eab2b93613529fc9169f169b0b8738b31dc6b6d5c7cd7326fb429bcdf81e3385569bc50f1741044649c561d2adb23841576987c2296b99c636ea1	2023-03-15 10:20:54	{"operacoes_id":[796,797]}
138	1	orders-2023.03.28-14 12 02.csv	csv	Operações Clear	f8e7e09e842c61177483de072f6a71ef99185db76ad66734f9bd94041529e4fc5cb22315ef09ea8b9a52d585803c8f9fd65c5a943bbfe404ae47855112d033b4	2023-03-28 17:40:15	{"operacoes_id":[802]}
140	1	proventos-recebidos-2023-03-01-a-2023-03-30.csv	csv	Proventos	c7467bf9b5058a40fda0be36b11d6f8121ff8acb58b9b8bc84279d3edfd600ec5bc6d4d8a9e9b18f13c7b7a72818e76129a606d8122bb8f3f714fbc16c8b20eb	2023-03-31 15:05:07	{"operacoes_id":[318,319,320,321,322,323,324,325,326]}
141	1	orders-2023.04.24-16 10 25.csv	csv	Operações Clear	8c4bbf259c6989abd68939090deda6389ae5b66d3c023248dbeabd2c86ce7abd79b43a3299ea7dc7caa7a039620f5a453987c19cf4127e98772e848f5eedb6f7	2023-04-24 16:11:27	{"operacoes_id":[810,811]}
142	1	orders-2023.04.26-16 23 05.csv	csv	Operações Clear	5933db4cc39cc1ee05191639eafcbe9eae5d6738ca08f815e04101a844287ad8c8054b32c1eb77221b6fccd033c08222b836dfa4aedf0ea30e9ccad6c18c807f	2023-04-28 16:30:49	{"operacoes_id":[812]}
\.


--
-- Data for Name: preco; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.preco (id, valor, ativo_id, data, atualiza_acoes_id) FROM stdin;
1	14.84	20	2023-02-06 20:22:37	\N
2	8.52	16	2023-02-06 20:22:37	\N
3	37.25	21	2023-02-06 20:22:37	\N
4	13.00	17	2023-02-06 20:22:37	\N
5	12.11	18	2023-02-06 20:22:37	\N
6	38.19	19	2023-02-06 20:22:37	\N
7	6.37	23	2023-02-06 20:22:37	\N
8	33.59	24	2023-02-06 20:22:37	\N
9	11.41	25	2023-02-06 20:22:37	\N
10	229.44	31	2023-02-06 20:22:37	\N
11	102.46	29	2023-02-06 20:22:37	\N
12	102.90	30	2023-02-06 20:22:37	\N
13	256.77	32	2023-02-06 20:22:37	\N
14	284.24	34	2023-02-06 20:22:37	\N
15	138.07	35	2023-02-06 20:22:37	\N
16	35.45	37	2023-02-06 20:22:37	\N
17	161.82	38	2023-02-06 20:22:37	\N
18	90.45	39	2023-02-06 20:22:37	\N
19	87.25	42	2023-02-06 20:22:37	\N
20	117.00	49	2023-02-06 20:22:37	\N
21	186.06	50	2023-02-06 20:22:37	\N
22	119935	51	2023-02-06 20:22:37	\N
23	7.96	53	2023-02-06 20:22:37	\N
24	131.44	54	2023-02-06 20:22:37	\N
25	67.73	55	2023-02-06 20:22:37	\N
26	5.1504	56	2023-02-06 20:22:37	\N
27	14.84	20	2023-02-06 20:40:25	\N
28	8.56	16	2023-02-06 20:40:25	\N
29	37.57	21	2023-02-06 20:40:25	\N
30	13.02	17	2023-02-06 20:40:25	\N
31	12.11	18	2023-02-06 20:40:25	\N
32	38.19	19	2023-02-06 20:40:25	\N
33	6.37	23	2023-02-06 20:40:25	\N
34	33.55	24	2023-02-06 20:40:25	\N
35	11.57	25	2023-02-06 20:40:25	\N
36	229.44	31	2023-02-06 20:40:25	\N
37	102.18	29	2023-02-06 20:40:25	\N
38	103.12	30	2023-02-06 20:40:25	\N
39	256.77	32	2023-02-06 20:40:25	\N
40	284.48	34	2023-02-06 20:40:25	\N
41	138.07	35	2023-02-06 20:40:25	\N
42	35.45	37	2023-02-06 20:40:25	\N
43	161.80	38	2023-02-06 20:40:25	\N
44	90.45	39	2023-02-06 20:40:25	\N
45	87.25	42	2023-02-06 20:40:25	\N
46	117.00	49	2023-02-06 20:40:25	\N
47	186.06	50	2023-02-06 20:40:25	\N
48	117580	51	2023-02-06 20:40:25	\N
49	7.96	53	2023-02-06 20:40:25	\N
50	131.44	54	2023-02-06 20:40:25	\N
51	67.18	55	2023-02-06 20:40:25	\N
52	5.1469	56	2023-02-06 20:40:25	\N
53	14.97	20	2023-02-08 11:24:35	\N
54	8.66	16	2023-02-08 11:24:35	\N
55	38.05	21	2023-02-08 11:24:35	\N
56	13.05	17	2023-02-08 11:24:35	\N
57	12.08	18	2023-02-08 11:24:35	\N
58	37.57	19	2023-02-08 11:24:35	\N
59	6.41	23	2023-02-08 11:24:35	\N
60	33.72	24	2023-02-08 11:24:35	\N
61	11.61	25	2023-02-08 11:24:35	\N
62	231.32	31	2023-02-08 11:24:35	\N
63	102.00	29	2023-02-08 11:24:35	\N
64	107.64	30	2023-02-08 11:24:35	\N
65	267.56	32	2023-02-08 11:24:35	\N
66	287.82	34	2023-02-08 11:24:35	\N
67	139.59	35	2023-02-08 11:24:35	\N
68	35.48	37	2023-02-08 11:24:35	\N
69	160.38	38	2023-02-08 11:24:35	\N
70	90.91	39	2023-02-08 11:24:36	\N
71	88.02	42	2023-02-08 11:24:36	\N
72	116.60	49	2023-02-08 11:24:36	\N
73	191.62	50	2023-02-08 11:24:36	\N
74	120324	51	2023-02-08 11:24:36	\N
75	7.99	53	2023-02-08 11:24:36	\N
76	130.27	54	2023-02-08 11:24:36	\N
77	67.37	55	2023-02-08 11:24:36	\N
78	5.1882	56	2023-02-08 11:24:36	\N
79	14.50	20	2023-02-12 11:29:45	\N
80	8.67	16	2023-02-12 11:29:45	\N
81	38.60	21	2023-02-12 11:29:45	\N
82	12.86	17	2023-02-12 11:29:45	\N
83	11.80	18	2023-02-12 11:29:45	\N
84	38.03	19	2023-02-12 11:29:45	\N
85	6.33	23	2023-02-12 11:29:45	\N
86	33.99	24	2023-02-12 11:29:45	\N
87	12.00	25	2023-02-12 11:29:45	\N
88	227.20	31	2023-02-12 11:29:45	\N
89	97.61	29	2023-02-12 11:29:45	\N
90	94.57	30	2023-02-12 11:29:45	\N
91	263.10	32	2023-02-12 11:29:45	\N
92	283.96	34	2023-02-12 11:29:45	\N
93	139.54	35	2023-02-12 11:29:45	\N
94	35.35	37	2023-02-12 11:29:46	\N
95	160.19	38	2023-02-12 11:29:46	\N
96	90.50	39	2023-02-12 11:29:46	\N
97	87.20	42	2023-02-12 11:29:46	\N
98	115.95	49	2023-02-12 11:29:46	\N
99	174.15	50	2023-02-12 11:29:46	\N
100	114621	51	2023-02-12 11:29:46	\N
101	8.00	53	2023-02-12 11:29:46	\N
102	128.09	54	2023-02-12 11:29:46	\N
103	66.85	55	2023-02-12 11:29:46	\N
104	5.2156	56	2023-02-12 11:29:46	\N
105	14.50	20	2023-02-12 11:31:48	\N
106	8.67	16	2023-02-12 11:31:48	\N
107	38.60	21	2023-02-12 11:31:48	\N
108	12.86	17	2023-02-12 11:31:48	\N
109	11.80	18	2023-02-12 11:31:48	\N
110	38.03	19	2023-02-12 11:31:48	\N
111	6.33	23	2023-02-12 11:31:48	\N
112	33.99	24	2023-02-12 11:31:48	\N
113	12.00	25	2023-02-12 11:31:48	\N
114	227.20	31	2023-02-12 11:31:48	\N
115	97.61	29	2023-02-12 11:31:48	\N
116	94.57	30	2023-02-12 11:31:48	\N
117	263.10	32	2023-02-12 11:31:48	\N
118	283.96	34	2023-02-12 11:31:48	\N
119	139.54	35	2023-02-12 11:31:48	\N
120	35.35	37	2023-02-12 11:31:48	\N
121	160.19	38	2023-02-12 11:31:48	\N
122	90.50	39	2023-02-12 11:31:48	\N
123	87.20	42	2023-02-12 11:31:48	\N
124	115.95	49	2023-02-12 11:31:48	\N
125	174.15	50	2023-02-12 11:31:48	\N
126	114783	51	2023-02-12 11:31:48	\N
127	8.00	53	2023-02-12 11:31:48	\N
128	128.09	54	2023-02-12 11:31:48	\N
129	66.85	55	2023-02-12 11:31:48	\N
130	5.2156	56	2023-02-12 11:31:48	\N
131	14.72	20	2023-02-13 13:47:42	\N
132	8.88	16	2023-02-13 13:47:42	\N
133	38.76	21	2023-02-13 13:47:42	\N
134	12.93	17	2023-02-13 13:47:42	\N
135	11.79	18	2023-02-13 13:47:42	\N
136	38.56	19	2023-02-13 13:47:42	\N
137	6.22	23	2023-02-13 13:47:42	\N
138	34.03	24	2023-02-13 13:47:42	\N
139	11.98	25	2023-02-13 13:47:42	\N
140	229.00	31	2023-02-13 13:47:42	\N
141	99.29	29	2023-02-13 13:47:42	\N
142	94.25	30	2023-02-13 13:47:42	\N
143	274.23	32	2023-02-13 13:47:42	\N
144	286.26	34	2023-02-13 13:47:42	\N
145	143.28	35	2023-02-13 13:47:42	\N
146	35.16	37	2023-02-13 13:47:42	\N
147	159.94	38	2023-02-13 13:47:42	\N
148	90.93	39	2023-02-13 13:47:42	\N
149	88.27	42	2023-02-13 13:47:43	\N
150	115.54	49	2023-02-13 13:47:43	\N
151	180.24	50	2023-02-13 13:47:43	\N
152	112030	51	2023-02-13 13:47:43	\N
153	7.93	53	2023-02-13 13:47:43	\N
154	129.15	54	2023-02-13 13:47:43	\N
155	67.06	55	2023-02-13 13:47:43	\N
156	5.1708	56	2023-02-13 13:47:43	\N
157	14.50	20	2023-02-22 16:33:52	\N
158	8.67	16	2023-02-22 16:33:52	\N
159	38.60	21	2023-02-22 16:33:52	\N
160	12.86	17	2023-02-22 16:33:52	\N
161	11.80	18	2023-02-22 16:33:52	\N
162	38.03	19	2023-02-22 16:33:52	\N
163	6.33	23	2023-02-22 16:33:52	\N
164	33.99	24	2023-02-22 16:33:52	\N
165	12.00	25	2023-02-22 16:33:52	\N
166	227.20	31	2023-02-22 16:33:52	\N
167	97.61	29	2023-02-22 16:33:52	\N
168	94.57	30	2023-02-22 16:33:52	\N
169	263.10	32	2023-02-22 16:33:52	\N
170	283.96	34	2023-02-22 16:33:52	\N
171	139.54	35	2023-02-22 16:33:52	\N
172	35.35	37	2023-02-22 16:33:52	\N
173	160.19	38	2023-02-22 16:33:52	\N
174	90.50	39	2023-02-22 16:33:52	\N
175	87.20	42	2023-02-22 16:33:52	\N
176	115.95	49	2023-02-22 16:33:52	\N
177	174.15	50	2023-02-22 16:33:52	\N
178	114621	51	2023-02-22 16:33:52	\N
179	8.00	53	2023-02-22 16:33:52	\N
180	128.09	54	2023-02-22 16:33:52	\N
181	66.85	55	2023-02-22 16:33:52	\N
182	5.2156	56	2023-02-22 16:33:52	\N
183	14.98	20	2023-02-22 16:35:36	\N
184	8.76	16	2023-02-22 16:35:36	\N
185	38.89	21	2023-02-22 16:35:36	\N
186	13.20	17	2023-02-22 16:35:36	\N
187	10.80	18	2023-02-22 16:35:36	\N
188	39.14	19	2023-02-22 16:35:36	\N
189	6.48	23	2023-02-22 16:35:36	\N
190	33.23	24	2023-02-22 16:35:36	\N
191	13.01	25	2023-02-22 16:35:36	\N
192	220.24	31	2023-02-22 16:35:36	\N
193	96.19	29	2023-02-22 16:35:36	\N
194	91.79	30	2023-02-22 16:35:37	\N
195	252.67	32	2023-02-22 16:35:37	\N
196	270.20	34	2023-02-22 16:35:37	\N
197	142.74	35	2023-02-22 16:35:37	\N
198	34.63	37	2023-02-22 16:35:37	\N
199	160.28	38	2023-02-22 16:35:37	\N
200	93.55	39	2023-02-22 16:35:37	\N
201	88.28	42	2023-02-22 16:35:37	\N
202	116.03	49	2023-02-22 16:35:37	\N
203	170.97	50	2023-02-22 16:35:37	\N
204	123767	51	2023-02-22 16:35:37	\N
205	8.01	53	2023-02-22 16:35:37	\N
206	123.28	54	2023-02-22 16:35:37	\N
207	66.05	55	2023-02-22 16:35:37	\N
208	5.1537	56	2023-02-22 16:35:37	\N
209	14.37	20	2023-02-28 17:32:19	\N
210	8.43	16	2023-02-28 17:32:19	\N
211	39.31	21	2023-02-28 17:32:19	\N
212	13.54	17	2023-02-28 17:32:19	\N
213	10.55	18	2023-02-28 17:32:19	\N
214	39.66	19	2023-02-28 17:32:19	\N
215	6.58	23	2023-02-28 17:32:19	\N
216	33.42	24	2023-02-28 17:32:19	\N
217	11.24	25	2023-02-28 17:32:19	\N
218	220.17	31	2023-02-28 17:32:19	\N
219	93.43	29	2023-02-28 17:32:19	\N
220	90.52	30	2023-02-28 17:32:19	\N
221	249.37	32	2023-02-28 17:32:19	\N
222	265.55	34	2023-02-28 17:32:19	\N
223	141.17	35	2023-02-28 17:32:19	\N
224	34.66	37	2023-02-28 17:32:19	\N
225	162.06	38	2023-02-28 17:32:19	\N
226	93.58	39	2023-02-28 17:32:19	\N
227	89.57	42	2023-02-28 17:32:19	\N
228	115.47	49	2023-02-28 17:32:19	\N
229	177.21	50	2023-02-28 17:32:19	\N
230	121972	51	2023-02-28 17:32:19	\N
231	7.97	53	2023-02-28 17:32:19	\N
232	124.00	54	2023-02-28 17:32:19	\N
233	64.51	55	2023-02-28 17:32:19	\N
234	5.2238	56	2023-02-28 17:32:19	\N
235	14.11	20	2023-03-06 16:17:58	\N
236	8.33	16	2023-03-06 16:17:58	\N
237	39.22	21	2023-03-06 16:17:58	\N
238	13.45	17	2023-03-06 16:17:58	\N
239	11.05	18	2023-03-06 16:17:58	\N
240	39.54	19	2023-03-06 16:17:58	\N
241	6.99	23	2023-03-06 16:17:58	\N
242	31.23	24	2023-03-06 16:17:58	\N
243	11.56	25	2023-03-06 16:17:58	\N
244	226.94	31	2023-03-06 16:17:58	\N
245	94.68	29	2023-03-06 16:17:58	\N
246	95.35	30	2023-03-06 16:17:58	\N
247	258.08	32	2023-03-06 16:17:58	\N
248	270.77	34	2023-03-06 16:17:58	\N
249	144.56	35	2023-03-06 16:17:58	\N
250	35.01	37	2023-03-06 16:17:58	\N
251	159.95	38	2023-03-06 16:17:58	\N
252	91.42	39	2023-03-06 16:17:58	\N
253	86.94	42	2023-03-06 16:17:58	\N
254	115.85	49	2023-03-06 16:17:58	\N
255	189.25	50	2023-03-06 16:17:58	\N
256	117029	51	2023-03-06 16:17:58	\N
257	7.99	53	2023-03-06 16:17:58	\N
258	127.10	54	2023-03-06 16:17:58	\N
259	64.41	55	2023-03-06 16:17:58	\N
260	5.1651	56	2023-03-06 16:17:58	\N
261	14.17	20	2023-03-07 18:14:50	\N
262	8.36	16	2023-03-07 18:14:50	\N
263	39.64	21	2023-03-07 18:14:50	\N
264	13.38	17	2023-03-07 18:14:50	\N
265	11.25	18	2023-03-07 18:14:50	\N
266	40.36	19	2023-03-07 18:14:50	\N
267	7.25	23	2023-03-07 18:14:50	\N
268	31.73	24	2023-03-07 18:14:50	\N
269	11.93	25	2023-03-07 18:14:50	\N
270	223.21	31	2023-03-07 18:14:50	\N
271	93.55	29	2023-03-07 18:14:50	\N
272	93.86	30	2023-03-07 18:14:50	\N
273	254.15	32	2023-03-07 18:14:50	\N
274	264.20	34	2023-03-07 18:14:50	\N
275	143.90	35	2023-03-07 18:14:50	\N
276	34.39	37	2023-03-07 18:14:50	\N
277	159.88	38	2023-03-07 18:14:50	\N
278	91.63	39	2023-03-07 18:14:50	\N
279	85.70	42	2023-03-07 18:14:50	\N
280	116.42	49	2023-03-07 18:14:50	\N
281	184.51	50	2023-03-07 18:14:50	\N
282	114826	51	2023-03-07 18:14:50	\N
283	8.00	53	2023-03-07 18:14:50	\N
284	123.83	54	2023-03-07 18:14:50	\N
285	63.88	55	2023-03-07 18:14:50	\N
286	5.1900	56	2023-03-07 18:14:50	\N
287	14.50	20	2023-03-10 19:11:59	\N
288	8.31	16	2023-03-10 19:11:59	\N
289	39.66	21	2023-03-10 19:11:59	\N
290	13.51	17	2023-03-10 19:11:59	\N
291	11.21	18	2023-03-10 19:11:59	\N
292	41.16	19	2023-03-10 19:11:59	\N
293	7.34	23	2023-03-10 19:11:59	\N
294	31.67	24	2023-03-10 19:11:59	\N
295	11.51	25	2023-03-10 19:11:59	\N
296	216.14	31	2023-03-10 19:11:59	\N
297	90.73	29	2023-03-10 19:11:59	\N
298	90.63	30	2023-03-10 19:11:59	\N
299	248.59	32	2023-03-10 19:11:59	\N
300	252.95	34	2023-03-10 19:11:59	\N
301	141.29	35	2023-03-10 19:11:59	\N
302	35.46	37	2023-03-10 19:11:59	\N
303	160.49	38	2023-03-10 19:11:59	\N
304	93.24	39	2023-03-10 19:11:59	\N
305	85.70	42	2023-03-10 19:11:59	\N
306	115.51	49	2023-03-10 19:11:59	\N
307	182.89	50	2023-03-10 19:11:59	\N
308	105469	51	2023-03-10 19:11:59	\N
309	7.94	53	2023-03-10 19:11:59	\N
310	116.98	54	2023-03-10 19:11:59	\N
311	61.38	55	2023-03-10 19:11:59	\N
312	5.2145	56	2023-03-10 19:11:59	\N
313	14.50	20	2023-03-10 19:13:41	\N
314	8.33	16	2023-03-10 19:13:41	\N
315	39.60	21	2023-03-10 19:13:41	\N
316	13.65	17	2023-03-10 19:13:41	\N
317	11.26	18	2023-03-10 19:13:41	\N
318	40.93	19	2023-03-10 19:13:41	\N
319	7.29	23	2023-03-10 19:13:41	\N
320	31.57	24	2023-03-10 19:13:41	\N
321	11.51	25	2023-03-10 19:13:41	\N
322	216.14	31	2023-03-10 19:13:41	\N
323	90.73	29	2023-03-10 19:13:41	\N
324	91.98	30	2023-03-10 19:13:41	\N
325	250.58	32	2023-03-10 19:13:41	\N
326	252.95	34	2023-03-10 19:13:41	\N
327	141.29	35	2023-03-10 19:13:41	\N
328	35.46	37	2023-03-10 19:13:41	\N
329	160.36	38	2023-03-10 19:13:41	\N
330	93.24	39	2023-03-10 19:13:41	\N
331	85.70	42	2023-03-10 19:13:41	\N
332	115.51	49	2023-03-10 19:13:41	\N
333	180.74	50	2023-03-10 19:13:41	\N
334	105608	51	2023-03-10 19:13:41	\N
335	7.92	53	2023-03-10 19:13:41	\N
336	116.98	54	2023-03-10 19:13:41	\N
337	61.38	55	2023-03-10 19:13:41	\N
338	5.2159	56	2023-03-10 19:13:41	\N
339	14.41	20	2023-03-14 18:16:30	\N
340	8.21	16	2023-03-14 18:16:30	\N
341	40.20	21	2023-03-14 18:16:30	\N
342	13.97	17	2023-03-14 18:16:30	\N
343	11.39	18	2023-03-14 18:16:30	\N
344	41.59	19	2023-03-14 18:16:30	\N
345	7.47	23	2023-03-14 18:16:30	\N
346	31.47	24	2023-03-14 18:16:30	\N
347	11.12	25	2023-03-14 18:16:30	\N
348	218.60	31	2023-03-14 18:16:30	\N
349	94.88	29	2023-03-14 18:16:30	\N
350	93.97	30	2023-03-14 18:16:30	\N
351	260.79	32	2023-03-14 18:16:30	\N
352	252.48	34	2023-03-14 18:16:30	\N
353	142.92	35	2023-03-14 18:16:30	\N
354	36.08	37	2023-03-14 18:16:30	\N
355	160.21	38	2023-03-14 18:16:30	\N
356	94.33	39	2023-03-14 18:16:30	\N
357	85.40	42	2023-03-14 18:16:30	\N
358	113.70	49	2023-03-14 18:16:30	\N
359	194.02	50	2023-03-14 18:16:30	\N
360	127850	51	2023-03-14 18:16:30	\N
361	7.94	53	2023-03-14 18:16:30	\N
362	119.78	54	2023-03-14 18:16:30	\N
363	63.20	55	2023-03-14 18:16:30	\N
364	5.2541	56	2023-03-14 18:16:30	\N
365	14.51	20	2023-03-17 18:46:59	\N
366	8.20	16	2023-03-17 18:46:59	\N
367	39.79	21	2023-03-17 18:46:59	\N
368	14.22	17	2023-03-17 18:46:59	\N
369	11.30	18	2023-03-17 18:46:59	\N
370	40.40	19	2023-03-17 18:46:59	\N
371	7.32	23	2023-03-17 18:46:59	\N
372	31.45	24	2023-03-17 18:46:59	\N
373	11.00	25	2023-03-17 18:46:59	\N
374	217.39	31	2023-03-17 18:46:59	\N
375	98.95	29	2023-03-17 18:46:59	\N
376	100.87	30	2023-03-17 18:46:59	\N
377	279.43	32	2023-03-17 18:46:59	\N
378	249.07	34	2023-03-17 18:46:59	\N
379	139.44	35	2023-03-17 18:46:59	\N
380	36.98	37	2023-03-17 18:46:59	\N
381	159.73	38	2023-03-17 18:46:59	\N
382	94.36	39	2023-03-17 18:46:59	\N
383	86.43	42	2023-03-17 18:46:59	\N
384	114.56	49	2023-03-17 18:46:59	\N
385	198.41	50	2023-03-17 18:46:59	\N
386	140368	51	2023-03-17 18:46:59	\N
387	7.89	53	2023-03-17 18:46:59	\N
388	116.03	54	2023-03-17 18:46:59	\N
389	61.93	55	2023-03-17 18:46:59	\N
390	5.2799	56	2023-03-17 18:46:59	\N
391	14.60	20	2023-03-26 17:47:51	\N
392	8.13	16	2023-03-26 17:47:51	\N
393	40.51	21	2023-03-26 17:47:51	\N
394	13.89	17	2023-03-26 17:47:51	\N
395	10.56	18	2023-03-26 17:47:51	\N
396	39.80	19	2023-03-26 17:47:51	\N
397	7.08	23	2023-03-26 17:47:51	\N
398	24.08	24	2023-03-26 17:47:51	\N
399	10.98	25	2023-03-26 17:47:51	\N
400	221.04	31	2023-03-26 17:47:51	\N
401	98.13	29	2023-03-26 17:47:51	\N
402	105.44	30	2023-03-26 17:47:51	\N
403	280.57	32	2023-03-26 17:47:51	\N
404	272.00	34	2023-03-26 17:47:51	\N
405	152.75	35	2023-03-26 17:47:51	\N
406	37.46	37	2023-03-26 17:47:51	\N
407	159.88	38	2023-03-26 17:47:51	\N
408	91.82	39	2023-03-26 17:47:51	\N
409	86.50	42	2023-03-26 17:47:51	\N
410	115.90	49	2023-03-26 17:47:51	\N
411	206.01	50	2023-03-26 17:47:51	\N
412	147190	51	2023-03-26 17:47:51	\N
413	7.84	53	2023-03-26 17:47:51	\N
414	117.03	54	2023-03-26 17:47:51	\N
415	61.04	55	2023-03-26 17:47:51	\N
416	5.2475	56	2023-03-26 17:47:51	\N
417	8.18	16	2023-03-28 18:20:29	\N
418	41.69	21	2023-03-28 18:20:29	\N
419	14.59	17	2023-03-28 18:20:29	\N
420	10.58	18	2023-03-28 18:20:29	\N
421	40.08	19	2023-03-28 18:20:29	\N
422	7.13	23	2023-03-28 18:20:29	\N
423	24.55	24	2023-03-28 18:20:29	\N
424	11.20	25	2023-03-28 18:20:29	\N
425	220.33	31	2023-03-28 18:20:30	\N
426	97.24	29	2023-03-28 18:20:30	\N
427	101.03	30	2023-03-28 18:20:30	\N
428	272.52	32	2023-03-28 18:20:30	\N
429	275.00	34	2023-03-28 18:20:30	\N
430	155.32	35	2023-03-28 18:20:30	\N
431	37.43	37	2023-03-28 18:20:30	\N
432	159.92	38	2023-03-28 18:20:30	\N
433	91.92	39	2023-03-28 18:20:30	\N
434	87.28	42	2023-03-28 18:20:30	\N
435	115.96	49	2023-03-28 18:20:30	\N
436	200.68	50	2023-03-28 18:20:30	\N
437	141621	51	2023-03-28 18:20:30	\N
438	7.85	53	2023-03-28 18:20:30	\N
439	116.65	54	2023-03-28 18:20:30	\N
440	61.06	55	2023-03-28 18:20:30	\N
441	5.1638	56	2023-03-28 18:20:30	\N
442	14.52	20	2023-04-02 09:58:27	\N
443	8.33	16	2023-04-02 09:58:27	\N
444	40.55	21	2023-04-02 09:58:27	\N
445	14.33	17	2023-04-02 09:58:27	\N
446	10.35	18	2023-04-02 09:58:27	\N
447	40.17	19	2023-04-02 09:58:27	\N
448	7.19	23	2023-04-02 09:58:27	\N
449	25.22	24	2023-04-02 09:58:27	\N
450	11.00	25	2023-04-02 09:58:27	\N
451	225.46	31	2023-04-02 09:58:27	\N
452	103.29	29	2023-04-02 09:58:27	\N
453	103.73	30	2023-04-02 09:58:27	\N
454	289.27	32	2023-04-02 09:58:27	\N
455	285.81	34	2023-04-02 09:58:27	\N
456	159.14	35	2023-04-02 09:58:27	\N
457	37.37	37	2023-04-02 09:58:27	\N
458	160.47	38	2023-04-02 09:58:27	\N
459	94.38	39	2023-04-02 09:58:27	\N
460	95.49	40	2023-04-02 09:58:27	\N
461	85.46	42	2023-04-02 09:58:27	\N
462	113.45	49	2023-04-02 09:58:27	\N
463	211.94	50	2023-04-02 09:58:27	\N
464	144703	51	2023-04-02 09:58:27	\N
465	7.75	53	2023-04-02 09:58:27	\N
466	124.77	54	2023-04-02 09:58:28	\N
467	63.32	55	2023-04-02 09:58:28	\N
468	5.0637	56	2023-04-02 09:58:28	\N
469	8.77	16	2023-04-16 11:35:11	\N
470	38.76	21	2023-04-16 11:35:11	\N
471	14.65	17	2023-04-16 11:35:11	\N
472	11.97	18	2023-04-16 11:35:11	\N
473	41.04	19	2023-04-16 11:35:11	\N
474	7.72	23	2023-04-16 11:35:11	\N
475	27.13	24	2023-04-16 11:35:11	\N
476	10.60	25	2023-04-16 11:35:11	\N
477	234.02	31	2023-04-16 11:35:11	\N
478	102.51	29	2023-04-16 11:35:11	\N
479	108.87	30	2023-04-16 11:35:11	\N
480	286.14	32	2023-04-16 11:35:11	\N
481	279.25	34	2023-04-16 11:35:11	\N
482	168.60	35	2023-04-16 11:35:11	\N
483	38.01	37	2023-04-16 11:35:11	\N
484	162.00	38	2023-04-16 11:35:11	\N
485	95.20	39	2023-04-16 11:35:11	\N
486	98.85	40	2023-04-16 11:35:11	\N
487	81.89	42	2023-04-16 11:35:11	\N
488	108.60	49	2023-04-16 11:35:11	\N
489	221.49	50	2023-04-16 11:35:11	\N
490	151181	51	2023-04-16 11:35:11	\N
491	7.60	53	2023-04-16 11:35:11	\N
492	119.76	54	2023-04-16 11:35:11	\N
493	60.77	55	2023-04-16 11:35:11	\N
494	4.9078	56	2023-04-16 11:35:11	\N
495	14.24	20	2023-04-21 08:57:17	\N
496	103.81	29	2023-04-21 08:57:17	\N
497	286.11	32	2023-04-21 08:57:17	\N
498	165.37	35	2023-04-21 08:57:17	\N
499	37.98	37	2023-04-21 08:57:17	\N
500	109.88	49	2023-04-21 08:57:17	\N
501	142944	51	2023-04-21 08:57:17	\N
502	123.25	54	2023-04-21 08:57:17	\N
503	5.0493	56	2023-04-21 08:57:17	\N
504	14.24	20	2023-04-21 09:02:39	\N
505	8.62	16	2023-04-21 09:02:39	\N
506	40.25	21	2023-04-21 09:02:39	\N
507	14.60	17	2023-04-21 09:02:39	\N
508	11.66	18	2023-04-21 09:02:39	\N
509	41.48	19	2023-04-21 09:02:39	\N
510	7.79	23	2023-04-21 09:02:39	\N
511	25.94	24	2023-04-21 09:02:39	\N
512	10.35	25	2023-04-21 09:02:39	\N
513	234.60	31	2023-04-21 09:02:39	\N
514	103.81	29	2023-04-21 09:02:39	\N
515	105.29	30	2023-04-21 09:02:39	\N
516	286.11	32	2023-04-21 09:02:39	\N
517	275.55	34	2023-04-21 09:02:39	\N
518	165.37	35	2023-04-21 09:02:39	\N
519	37.98	37	2023-04-21 09:02:39	\N
520	162.19	38	2023-04-21 09:02:39	\N
521	96.54	39	2023-04-21 09:02:39	\N
522	99.62	40	2023-04-21 09:02:39	\N
523	82.90	42	2023-04-21 09:02:39	\N
524	109.88	49	2023-04-21 09:02:39	\N
525	213.07	50	2023-04-21 09:02:39	\N
526	142396	51	2023-04-21 09:02:39	\N
527	7.85	53	2023-04-21 09:02:39	\N
528	123.25	54	2023-04-21 09:02:39	\N
529	61.93	55	2023-04-21 09:02:39	\N
530	5.0493	56	2023-04-21 09:02:39	\N
531	14.43	20	2023-04-28 16:31:58	\N
532	8.77	16	2023-04-28 16:31:58	\N
533	40.91	21	2023-04-28 16:31:58	\N
534	14.12	17	2023-04-28 16:31:58	\N
535	11.61	18	2023-04-28 16:31:58	\N
536	41.01	19	2023-04-28 16:31:58	\N
537	8.12	23	2023-04-28 16:31:58	\N
538	28.42	24	2023-04-28 16:31:58	\N
539	10.01	25	2023-04-28 16:31:58	\N
540	233.04	31	2023-04-28 16:31:58	\N
541	105.57	29	2023-04-28 16:31:58	\N
542	106.89	30	2023-04-28 16:31:58	\N
543	305.18	32	2023-04-28 16:31:58	\N
544	167.27	35	2023-04-28 16:31:58	\N
545	37.73	37	2023-04-28 16:31:58	\N
546	162.49	38	2023-04-28 16:31:58	\N
547	102.21	39	2023-04-28 16:31:58	\N
548	103.08	40	2023-04-28 16:31:58	\N
549	82.84	42	2023-04-28 16:31:58	\N
550	112.33	49	2023-04-28 16:31:58	\N
551	236.79	50	2023-04-28 16:31:58	\N
552	147384	51	2023-04-28 16:31:58	\N
553	7.80	53	2023-04-28 16:31:58	\N
554	124.45	54	2023-04-28 16:31:58	\N
555	62.69	55	2023-04-28 16:31:58	\N
556	4.9903	56	2023-04-28 16:31:58	\N
\.


--
-- Data for Name: proventos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.proventos (id, data, valor, itens_ativos_id, movimentacao) FROM stdin;
184	2022-05-26 00:00:00	31.88	31	1
185	2022-05-26 00:00:00	21.48	31	2
186	2022-05-26 00:00:00	63.24	12	3
187	2022-05-19 00:00:00	0.15	31	1
188	2022-05-19 00:00:00	42.37	31	2
189	2022-05-14 00:00:00	56.1	10	3
190	2022-05-14 00:00:00	118.8	13	3
191	2022-05-14 00:00:00	68.64	11	3
192	2022-05-10 00:00:00	44.64	43	3
193	2022-06-30 00:00:00	6.04	8	2
194	2022-06-24 00:00:00	63.24	12	3
195	2022-06-15 00:00:00	130	13	3
196	2022-06-14 00:00:00	56.1	10	3
197	2022-06-14 00:00:00	70.72	11	3
198	2022-06-08 00:00:00	53.55	43	3
199	2022-07-25 00:00:00	37.26	12	3
200	2022-07-15 00:00:00	179.08	13	3
201	2022-07-14 00:00:00	102.3	10	3
202	2022-07-14 00:00:00	41.3	11	3
203	2022-07-12 00:00:00	74.79	30	1
204	2022-07-08 00:00:00	15.84	29	2
205	2022-07-08 00:00:00	21.38	29	1
206	2022-07-08 00:00:00	163.28	43	3
207	2022-07-06 00:00:00	9.09	9	2
208	2022-07-01 00:00:00	8.96	26	2
219	2022-08-31 00:00:00	5.22	31	1
220	2022-08-31 00:00:00	10.45	31	2
221	2022-08-30 00:00:00	47.09	26	2
222	2022-09-30 00:00:00	6.04	8	2
223	2022-09-23 00:00:00	39.42	12	3
224	2022-09-15 00:00:00	34.1	10	3
225	2022-09-15 00:00:00	4.83	48	3
226	2022-09-15 00:00:00	162.8	13	3
227	2022-09-15 00:00:00	43.2	11	3
228	2022-09-09 00:00:00	176.49	43	3
275	2022-11-25 00:00:00	48	12	3
276	2022-11-23 00:00:00	19.74	31	2
277	2022-11-23 00:00:00	40.35	31	1
278	2022-11-16 00:00:00	34.1	10	3
279	2022-11-16 00:00:00	7.8	48	3
280	2022-11-16 00:00:00	44.4	11	3
281	2022-11-14 00:00:00	163	13	3
282	2022-11-09 00:00:00	190.65	43	3
301	2023-01-25 00:00:00	61.2	12	3
302	2023-01-13 00:00:00	16.64	29	2
303	2023-01-13 00:00:00	68.2	10	3
304	2023-01-13 00:00:00	13.32	48	3
305	2023-01-13 00:00:00	155.699	13	3
306	2023-01-13 00:00:00	45.88	11	3
307	2023-01-09 00:00:00	166.4	43	3
308	2023-02-24 00:00:00	52.359	12	3
309	2023-02-15 00:00:00	174	13	3
310	2023-02-14 00:00:00	34.1	10	3
311	2023-02-14 00:00:00	12.369	48	3
312	2023-02-14 00:00:00	46.619	11	3
313	2023-02-08 00:00:00	167.699	43	3
327	2023-03-31 15:05:20	2.81	8	2
1	2019-08-01 00:00:00	1.43	31	1
2	2019-08-01 11:05:00	34.05	26	1
3	2019-08-01 00:00:00	3.83	27	1
4	2019-10-01 00:00:00	6.94	29	1
5	2019-10-01 00:00:00	1.07	24	1
6	2019-10-01 00:00:00	6.64	25	1
9	2019-11-01 00:00:00	16.22	31	1
10	2019-12-01 00:00:00	36.28	28	1
11	2019-12-01 00:00:00	4.19	9	1
12	2020-01-01 00:00:00	1.62	24	1
13	2020-01-01 00:00:00	2.2	26	1
14	2020-01-01 00:00:00	2.26	9	1
15	2020-01-01 00:00:00	35.03	30	1
16	2020-01-01 00:00:00	5.64	25	1
17	2020-01-01 00:00:00	10.08	29	1
8	2019-10-01 00:00:00	1.96	9	1
7	2019-10-01 00:00:00	2	26	1
18	2020-03-01 00:00:00	50.74	26	1
19	2020-03-01 00:00:00	13.58	27	1
20	2020-04-01 00:00:00	2.07	24	1
21	2020-04-01 00:00:00	10.44	8	1
22	2020-04-01 00:00:00	2.44	26	1
23	2020-04-01 00:00:00	11.03	29	1
24	2020-04-01 00:00:00	2.2	9	1
25	2020-05-01 00:00:00	12.08	29	1
26	2020-05-01 00:00:00	29.5	31	1
27	2020-07-01 00:00:00	9.69	9	1
28	2020-07-01 00:00:00	2.94	26	1
29	2020-07-01 00:00:00	11.8	30	1
30	2020-08-01 00:00:00	3.86	26	1
31	2020-08-01 00:00:00	5.37	29	1
32	2020-08-01 00:00:00	3	24	1
33	2020-08-01 00:00:00	10.92	27	1
34	2020-10-10 00:00:00	3.86	26	1
35	2020-10-01 00:00:00	33.29	29	1
36	2020-10-01 00:00:00	35.69	9	1
37	2020-11-01 00:00:00	6.94	31	1
38	2020-12-01 00:00:00	65.76	28	1
39	2020-12-01 00:00:00	36.83	25	1
40	2020-12-01 00:00:00	23.8	9	1
41	2021-01-01 00:00:00	77.68	30	1
42	2021-01-01 00:00:00	14.41	28	1
43	2021-01-01 00:00:00	4.58	26	1
44	2021-01-01 00:00:00	3.47	9	1
45	2021-01-01 00:00:00	23.02	29	1
47	2020-09-11 00:00:00	0.36	34	1
46	2020-09-02 00:00:00	0.21	15	1
48	2020-12-30 14:10:00	0.88	34	1
49	2020-12-30 14:10:00	0.41	15	1
50	2021-03-31 13:15:00	0.23	24	1
51	2021-03-31 13:15:00	3.9	10	1
53	2021-03-31 13:15:00	4.5	12	1
54	2021-03-31 13:15:00	20.15	25	1
55	2021-03-31 13:20:00	4.64	11	1
56	2021-03-31 13:20:00	19.58	27	1
52	2021-03-31 13:15:00	23.83	26	1
57	2021-03-01 09:05:00	1.17	34	1
58	2021-03-11 09:10:00	0.61	15	1
59	2021-04-01 09:20:00	7.35	12	1
60	2021-04-01 09:25:00	6.56	26	1
61	2021-04-01 09:25:00	24.19	11	1
62	2021-04-01 09:25:00	31.39	29	1
63	2021-04-01 09:25:00	19.5	10	1
64	2021-04-01 09:25:00	5.33	9	1
65	2021-04-01 09:25:00	9.48	30	1
66	2021-04-01 09:25:00	67.23	25	1
67	2021-04-01 09:25:00	4.55	8	1
68	2021-05-03 11:05:00	279.74	31	1
69	2021-05-04 11:05:00	22.54	8	1
70	2021-05-13 11:05:00	22.8	12	1
71	2021-05-03 11:05:00	39.6	11	1
72	2021-05-03 11:05:00	37.48	29	1
73	2021-05-03 11:05:00	35.88	10	1
74	2021-06-02 10:30:00	46	10	1
75	2021-06-03 10:55:00	32.4	12	1
76	2021-06-03 10:55:00	45.14	11	1
107	2021-07-05 12:10:00	8.4	26	1
108	2021-07-05 12:10:00	63.56	29	1
109	2021-07-06 12:10:00	112.2	10	1
110	2021-07-06 12:10:00	42.12	12	1
111	2021-07-06 13:15:00	13.26	13	1
112	2021-07-15 12:15:00	45.14	11	1
113	2021-07-15 12:15:00	116.51	9	1
114	2021-07-14 12:15:00	81.43	30	1
115	2021-08-04 09:15:00	45.88	11	1
116	2021-08-11 14:15:00	0.62	24	1
117	2021-08-03 09:15:00	48.6	12	1
118	2021-08-10 13:15:00	19.68	25	1
119	2021-08-10 13:15:00	27.51	27	1
120	2021-08-10 12:15:00	56.1	10	1
121	2021-08-11 12:20:00	22.93	31	1
122	2021-08-11 12:20:00	22.47	13	1
123	2021-08-11 12:20:00	37.15	26	1
124	2021-09-07 14:00:00	45.9	13	1
125	2021-09-08 14:00:00	56.1	10	1
126	2021-09-14 14:05:00	6.04	8	1
127	2021-09-07 09:05:00	46.17	12	1
128	2021-09-07 09:30:00	45.88	11	1
129	2021-10-04 15:25:00	57.52	29	1
130	2021-10-11 15:25:00	45.88	11	1
131	2021-10-04 15:25:00	8.5	26	1
132	2021-10-12 15:25:00	73.7	13	1
133	2021-10-05 15:25:00	56.1	10	1
134	2021-10-12 15:25:00	46.17	12	1
135	2021-10-12 15:25:00	7.37	9	1
136	2021-12-15 12:50:00	97.5	13	1
137	2021-12-14 12:50:00	56.1	10	1
138	2021-12-14 12:55:00	59.52	11	1
139	2021-11-29 12:55:00	107.4	30	1
141	2021-11-24 13:00:00	91.79	31	1
140	2021-11-25 12:55:00	40.5	12	1
142	2021-11-16 13:00:00	56.1	10	1
143	2021-11-16 13:00:00	50.56	11	1
144	2021-11-12 13:00:00	92.4	13	1
145	2021-12-23 11:00:00	51.5	12	1
146	2021-12-28 11:00:00	48.85	31	1
147	2021-12-30 11:05:00	6.75	9	1
148	2021-12-30 11:05:00	6.04	8	1
149	2021-12-30 11:05:00	14.02	25	1
150	2021-12-30 11:05:00	45.73	29	1
151	2021-12-30 11:05:00	152.45	28	1
154	2022-01-14 16:25:00	89.25	10	1
155	2022-01-14 16:25:00	95.4	13	1
156	2022-01-14 16:30:00	65.92	11	1
157	2022-01-07 16:30:00	12.95	29	1
153	2022-01-25 16:25:00	79.05	12	1
158	2022-02-25 11:30:25	55.8	12	1
159	2022-02-18 11:30:54	210.82	8	1
160	2022-02-15 11:30:22	105.4	13	1
161	2022-02-14 11:30:35	56.1	10	1
162	2022-02-14 11:30:18	65.92	11	1
163	2022-03-04 10:05:25	2.62	26	1
164	2022-03-09 10:05:50	28.06	43	1
165	2022-03-11 10:05:20	50.8	26	1
166	2022-03-11 10:10:01	55.89	26	1
167	2022-03-15 10:10:39	56.1	10	1
168	2022-03-15 10:10:27	118.75	13	1
169	2022-03-16 10:10:02	2.64	27	1
170	2022-03-16 10:10:38	4.08	27	1
171	2022-03-16 10:10:12	30.78	27	1
172	2022-03-17 10:10:43	86.88	30	1
173	2022-03-17 10:10:09	6.94	30	1
174	2022-03-15 10:15:11	67.98	11	1
175	2022-04-25 07:55:36	61.38	12	1
176	2022-04-14 07:55:36	56.1	10	1
177	2022-04-14 07:55:30	110.4	13	1
178	2022-04-14 07:55:53	67.98	11	1
179	2022-04-08 07:55:23	40.14	29	1
180	2022-04-08 07:55:52	13.09	29	1
181	2022-04-08 07:55:16	35.56	43	1
182	2022-04-04 07:55:59	123.5	25	1
183	2022-04-01 08:00:45	8.5	26	1
212	2022-08-25 00:00:00	37.8	12	3
213	2022-08-17 00:00:00	19.79	27	1
214	2022-08-17 00:00:00	10.21	27	2
215	2022-08-15 00:00:00	162.8	13	3
216	2022-08-12 00:00:00	34.1	10	3
217	2022-08-12 00:00:00	43.2	11	3
218	2022-08-08 00:00:00	170.64	43	3
265	2022-10-25 00:00:00	40.5	12	3
266	2022-10-17 00:00:00	34.1	10	3
267	2022-10-17 00:00:00	5.77	48	3
268	2022-10-17 00:00:00	44.4	11	3
269	2022-10-14 00:00:00	154	13	3
270	2022-10-10 00:00:00	178.08	43	3
271	2022-10-07 00:00:00	8.6	29	1
272	2022-10-07 00:00:00	14.24	29	2
273	2022-10-05 00:00:00	65.93	9	1
274	2022-10-03 00:00:00	8.96	26	2
288	2022-12-29 00:00:00	186.61	28	2
289	2022-12-29 00:00:00	7.4	29	1
290	2022-12-29 00:00:00	43.55	25	2
291	2022-12-29 00:00:00	4.08	8	2
292	2022-12-27 00:00:00	19.96	9	2
293	2022-12-23 00:00:00	51.59	12	3
294	2022-12-21 00:00:00	9.92	9	2
295	2022-12-15 00:00:00	155.7	13	3
296	2022-12-14 00:00:00	34.1	10	3
297	2022-12-14 00:00:00	9.52	48	3
298	2022-12-14 00:00:00	44.4	11	3
299	2022-12-12 00:00:00	142.93	30	1
300	2022-12-08 00:00:00	189	43	3
318	2023-03-24 00:00:00	53.82	12	3
319	2023-03-15 00:00:00	165.3	13	3
320	2023-03-15 00:00:00	16.06	27	1
321	2023-03-15 00:00:00	10.1	27	2
322	2023-03-14 00:00:00	49.5	10	3
323	2023-03-14 00:00:00	23.32	48	3
324	2023-03-14 00:00:00	168.99	43	3
325	2023-03-14 00:00:00	55.5	11	3
326	2023-03-10 00:00:00	59.06	26	2
\.


--
-- Data for Name: site_acoes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.site_acoes (ativo_id, url) FROM stdin;
20	https://br.investing.com/equities/fleury-on-nm
16	https://br.investing.com/equities/itausa-on-ej-n1
21	https://br.investing.com/equities/weg-on-ej-nm
17	https://br.investing.com/equities/ambev-pn
18	https://br.investing.com/equities/bmfbovespa-on-nm
19	https://br.investing.com/equities/tractebel-on-nm
23	https://br.investing.com/equities/grendene-on-nm
24	https://br.investing.com/equities/m.diasbranco-on-ej-nm
25	https://br.investing.com/equities/odontoprev-on-ej-nm
31	https://br.investing.com/equities/visa-inc
29	https://br.investing.com/equities/amazon-com-inc
30	https://br.investing.com/equities/google-inc
32	https://br.investing.com/equities/microsoft-corp
34	https://br.investing.com/equities/accenture-ltd
35	https://br.investing.com/equities/novo-nordis
37	https://br.investing.com/etfs/ishares-comex-gold-trust
38	https://br.investing.com/equities/fii-cshg-log
39	https://br.investing.com/equities/xp-log-fdo-inv-imob-cf
40	https://br.investing.com/equities/xp-malls-fdo-inv-imob-fii
42	https://br.investing.com/equities/fii-fator-ve
49	https://br.investing.com/equities/fii-tg-ativo-real
50	https://br.investing.com/equities/facebook-inc
51	https://br.investing.com/crypto/bitcoin/btc-brl
53	https://br.investing.com/equities/kilima-fundos-imob-suno-30
54	https://br.investing.com/equities/prologis
55	https://br.investing.com/equities/realty-income
56	https://br.investing.com/currencies/usd-brl
\.


--
-- Data for Name: user; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public."user" (id, username, password, authkey) FROM stdin;
2	admin	$2y$13$7IJhzQz16h97RiQIU0HuWOn8QLOSbBjMkGVAzuQjgXzvtD.yI.FZ6	\N
\.


--
-- Name: acao_bolsa_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.acao_bolsa_id_seq', 312, true);


--
-- Name: ativo_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.ativo_id_seq', 58, true);


--
-- Name: atualiza_acoes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.atualiza_acoes_id_seq', 1, false);


--
-- Name: atualiza_ativo_manual_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.atualiza_ativo_manual_id_seq', 1, true);


--
-- Name: atualiza_nu_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.atualiza_nu_id_seq', 5, true);


--
-- Name: atualiza_operacoes_manual_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.atualiza_operacoes_manual_id_seq', 4, true);


--
-- Name: auditoria_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.auditoria_id_seq', 10756, true);


--
-- Name: classes_operacoes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.classes_operacoes_id_seq', 4, true);


--
-- Name: investidor_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.investidor_id_seq', 5, true);


--
-- Name: itens_ativo_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.itens_ativo_id_seq', 56, true);


--
-- Name: operacao_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.operacao_id_seq', 841, true);


--
-- Name: operacoes_import_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.operacoes_import_id_seq', 142, true);


--
-- Name: preco_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.preco_id_seq', 556, true);


--
-- Name: proventos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.proventos_id_seq', 328, true);


--
-- Name: user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.user_id_seq', 3, true);


--
-- Name: acao_bolsa acao_bolsa_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.acao_bolsa
    ADD CONSTRAINT acao_bolsa_pkey PRIMARY KEY (id);


--
-- Name: ativo ativo_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ativo
    ADD CONSTRAINT ativo_pkey PRIMARY KEY (id);


--
-- Name: site_acoes atualiza_acao_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.site_acoes
    ADD CONSTRAINT atualiza_acao_pkey PRIMARY KEY (ativo_id);


--
-- Name: atualiza_acoes atualiza_acoes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.atualiza_acoes
    ADD CONSTRAINT atualiza_acoes_pkey PRIMARY KEY (id);


--
-- Name: atualiza_ativo_manual atualiza_ativo_manual_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.atualiza_ativo_manual
    ADD CONSTRAINT atualiza_ativo_manual_pkey PRIMARY KEY (id);


--
-- Name: atualiza_nu atualiza_nu_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.atualiza_nu
    ADD CONSTRAINT atualiza_nu_pkey PRIMARY KEY (id);


--
-- Name: atualiza_operacoes_manual atualiza_operacoes_manual_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.atualiza_operacoes_manual
    ADD CONSTRAINT atualiza_operacoes_manual_pkey PRIMARY KEY (id);


--
-- Name: auditoria auditoria_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.auditoria
    ADD CONSTRAINT auditoria_pkey PRIMARY KEY (id);


--
-- Name: auth_assignment auth_assignment_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.auth_assignment
    ADD CONSTRAINT auth_assignment_pkey PRIMARY KEY (item_name, user_id);


--
-- Name: auth_item_child auth_item_child_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.auth_item_child
    ADD CONSTRAINT auth_item_child_pkey PRIMARY KEY (parent, child);


--
-- Name: auth_item auth_item_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.auth_item
    ADD CONSTRAINT auth_item_pkey PRIMARY KEY (name);


--
-- Name: auth_rule auth_rule_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.auth_rule
    ADD CONSTRAINT auth_rule_pkey PRIMARY KEY (name);


--
-- Name: classes_operacoes classes_operacoes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.classes_operacoes
    ADD CONSTRAINT classes_operacoes_pkey PRIMARY KEY (id);


--
-- Name: investidor investidor_cpf_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.investidor
    ADD CONSTRAINT investidor_cpf_key UNIQUE (cpf);


--
-- Name: investidor investidor_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.investidor
    ADD CONSTRAINT investidor_pkey PRIMARY KEY (id);


--
-- Name: itens_ativo itens_ativo_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.itens_ativo
    ADD CONSTRAINT itens_ativo_pkey PRIMARY KEY (id);


--
-- Name: migration migration_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migration
    ADD CONSTRAINT migration_pkey PRIMARY KEY (version);


--
-- Name: operacao operacao_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.operacao
    ADD CONSTRAINT operacao_pkey PRIMARY KEY (id);


--
-- Name: operacoes_import operacoes_import_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.operacoes_import
    ADD CONSTRAINT operacoes_import_pkey PRIMARY KEY (id);


--
-- Name: preco preco_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.preco
    ADD CONSTRAINT preco_pkey PRIMARY KEY (id);


--
-- Name: proventos proventos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.proventos
    ADD CONSTRAINT proventos_pkey PRIMARY KEY (id);


--
-- Name: user user_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."user"
    ADD CONSTRAINT user_pkey PRIMARY KEY (id);


--
-- Name: bolsa_acao_codigo; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX bolsa_acao_codigo ON public.acao_bolsa USING btree (codigo);


--
-- Name: classe_operacoes_unique; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX classe_operacoes_unique ON public.classes_operacoes USING btree (nome);


--
-- Name: idx-auth_assignment-user_id; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX "idx-auth_assignment-user_id" ON public.auth_assignment USING btree (user_id);


--
-- Name: idx-auth_item-type; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX "idx-auth_item-type" ON public.auth_item USING btree (type);


--
-- Name: intes_ativo_unique_investidor; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX intes_ativo_unique_investidor ON public.itens_ativo USING btree (investidor_id, ativo_id);


--
-- Name: unique_atualiza_ativo_manual; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX unique_atualiza_ativo_manual ON public.atualiza_ativo_manual USING btree (itens_ativo_id);


--
-- Name: unique_atualiza_operacoes_manual; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX unique_atualiza_operacoes_manual ON public.atualiza_operacoes_manual USING btree (atualiza_ativo_manual_id, data);


--
-- Name: unique_cnpj; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX unique_cnpj ON public.acao_bolsa USING btree (cnpj);


--
-- Name: unique_hash_investido; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX unique_hash_investido ON public.operacoes_import USING btree (investidor_id, hash_nome);


--
-- Name: unique_mv_data_ativo; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX unique_mv_data_ativo ON public.proventos USING btree (data, itens_ativos_id, movimentacao);


--
-- Name: unique_operacoes_import_ativo; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX unique_operacoes_import_ativo ON public.atualiza_nu USING btree (operacoes_import_id, itens_ativo_id);


--
-- Name: unique_user; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX unique_user ON public."user" USING btree (username);


--
-- Name: ativo ativo_acao_bolsa_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ativo
    ADD CONSTRAINT ativo_acao_bolsa_id_fkey FOREIGN KEY (acao_bolsa_id) REFERENCES public.acao_bolsa(id);


--
-- Name: preco ativo_preco_id_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.preco
    ADD CONSTRAINT ativo_preco_id_fk FOREIGN KEY (ativo_id) REFERENCES public.ativo(id);


--
-- Name: site_acoes atualiza_acao_ativo_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.site_acoes
    ADD CONSTRAINT atualiza_acao_ativo_id_fkey FOREIGN KEY (ativo_id) REFERENCES public.ativo(id);


--
-- Name: preco atualiza_acoes_id_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.preco
    ADD CONSTRAINT atualiza_acoes_id_fk FOREIGN KEY (atualiza_acoes_id) REFERENCES public.atualiza_acoes(id);


--
-- Name: atualiza_ativo_manual atualiza_ativo_manual_itens_ativo_id_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.atualiza_ativo_manual
    ADD CONSTRAINT atualiza_ativo_manual_itens_ativo_id_fk FOREIGN KEY (itens_ativo_id) REFERENCES public.itens_ativo(id);


--
-- Name: atualiza_nu atualiza_nu_itens_ativo_pk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.atualiza_nu
    ADD CONSTRAINT atualiza_nu_itens_ativo_pk FOREIGN KEY (itens_ativo_id) REFERENCES public.itens_ativo(id);


--
-- Name: atualiza_nu atualiza_nu_operacoes_import_pk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.atualiza_nu
    ADD CONSTRAINT atualiza_nu_operacoes_import_pk FOREIGN KEY (operacoes_import_id) REFERENCES public.operacoes_import(id);


--
-- Name: atualiza_operacoes_manual atualiza_operacoes_manual_atualiza_ativo_manual_id_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.atualiza_operacoes_manual
    ADD CONSTRAINT atualiza_operacoes_manual_atualiza_ativo_manual_id_fk FOREIGN KEY (atualiza_ativo_manual_id) REFERENCES public.atualiza_ativo_manual(id);


--
-- Name: auditoria auditoria_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.auditoria
    ADD CONSTRAINT auditoria_user_id_fkey FOREIGN KEY (user_id) REFERENCES public."user"(id);


--
-- Name: auth_assignment auth_assignment_item_name_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.auth_assignment
    ADD CONSTRAINT auth_assignment_item_name_fkey FOREIGN KEY (item_name) REFERENCES public.auth_item(name) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: auth_item_child auth_item_child_child_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.auth_item_child
    ADD CONSTRAINT auth_item_child_child_fkey FOREIGN KEY (child) REFERENCES public.auth_item(name) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: auth_item_child auth_item_child_parent_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.auth_item_child
    ADD CONSTRAINT auth_item_child_parent_fkey FOREIGN KEY (parent) REFERENCES public.auth_item(name) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: auth_item auth_item_rule_name_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.auth_item
    ADD CONSTRAINT auth_item_rule_name_fkey FOREIGN KEY (rule_name) REFERENCES public.auth_rule(name) ON UPDATE CASCADE ON DELETE SET NULL;


--
-- Name: ativo classe_atualiza_id_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ativo
    ADD CONSTRAINT classe_atualiza_id_fk FOREIGN KEY (classe_atualiza_id) REFERENCES public.classes_operacoes(id);


--
-- Name: operacao fk_itens_ativos; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.operacao
    ADD CONSTRAINT fk_itens_ativos FOREIGN KEY (itens_ativos_id) REFERENCES public.itens_ativo(id);


--
-- Name: itens_ativo itens_ativo_ativo_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.itens_ativo
    ADD CONSTRAINT itens_ativo_ativo_id_fkey FOREIGN KEY (ativo_id) REFERENCES public.ativo(id);


--
-- Name: itens_ativo itens_ativo_investidor_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.itens_ativo
    ADD CONSTRAINT itens_ativo_investidor_id_fkey FOREIGN KEY (investidor_id) REFERENCES public.investidor(id);


--
-- Name: proventos itens_ativos_proventos_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.proventos
    ADD CONSTRAINT itens_ativos_proventos_fk FOREIGN KEY (itens_ativos_id) REFERENCES public.itens_ativo(id);


--
-- Name: operacoes_import operacoes_import_investidor_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.operacoes_import
    ADD CONSTRAINT operacoes_import_investidor_id_fkey FOREIGN KEY (investidor_id) REFERENCES public.investidor(id);


--
-- PostgreSQL database dump complete
--

