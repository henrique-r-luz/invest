--
-- PostgreSQL database dump
--

-- Dumped from database version 10.10 (Ubuntu 10.10-0ubuntu0.18.04.1)
-- Dumped by pg_dump version 10.10 (Ubuntu 10.10-0ubuntu0.18.04.1)

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
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: acao_bolsa; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.acao_bolsa (
    id integer NOT NULL,
    nome text NOT NULL,
    codigo text NOT NULL,
    setor text NOT NULL,
    cnpj text NOT NULL
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
    quantidade real,
    valor_compra real,
    valor_bruto real,
    valor_liquido real,
    tipo_id integer NOT NULL,
    categoria_id integer NOT NULL,
    ativo boolean DEFAULT true NOT NULL,
    acao_bolsa_id integer
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
-- Name: balanco_empresa_bolsa; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.balanco_empresa_bolsa (
    id integer NOT NULL,
    cnpj text NOT NULL,
    tag_along_on smallint,
    free_float_on smallint,
    governo boolean,
    data text,
    patrimonio_liquido real,
    receita_liquida real,
    ebitda real,
    da real,
    ebit real,
    margem_ebit smallint,
    resultado_financeiro real,
    imposto real,
    lucro_liquido real,
    margem_liquida smallint,
    roe smallint,
    caixa real,
    divida_bruta real,
    divida_liquida real,
    divida_bruta_patrimonio smallint,
    divida_liquida_ebitda real,
    fco real,
    capex real,
    fcf real,
    fcl real,
    capex_fco smallint,
    proventos real,
    payout smallint,
    anual smallint
);


ALTER TABLE public.balanco_empresa_bolsa OWNER TO postgres;

--
-- Name: balanco_empresa_bolsa_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.balanco_empresa_bolsa_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.balanco_empresa_bolsa_id_seq OWNER TO postgres;

--
-- Name: balanco_empresa_bolsa_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.balanco_empresa_bolsa_id_seq OWNED BY public.balanco_empresa_bolsa.id;


--
-- Name: categoria; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.categoria (
    id integer NOT NULL,
    nome text NOT NULL
);


ALTER TABLE public.categoria OWNER TO postgres;

--
-- Name: categoria_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.categoria_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.categoria_id_seq OWNER TO postgres;

--
-- Name: categoria_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.categoria_id_seq OWNED BY public.categoria.id;


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
    quantidade real NOT NULL,
    valor real NOT NULL,
    data timestamp without time zone NOT NULL,
    ativo_id integer NOT NULL,
    tipo integer NOT NULL
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
-- Name: tipo; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tipo (
    id integer NOT NULL,
    nome text NOT NULL
);


ALTER TABLE public.tipo OWNER TO postgres;

--
-- Name: tipo_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tipo_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tipo_id_seq OWNER TO postgres;

--
-- Name: tipo_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tipo_id_seq OWNED BY public.tipo.id;


--
-- Name: acao_bolsa id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.acao_bolsa ALTER COLUMN id SET DEFAULT nextval('public.acao_bolsa_id_seq'::regclass);


--
-- Name: ativo id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ativo ALTER COLUMN id SET DEFAULT nextval('public.ativo_id_seq'::regclass);


--
-- Name: balanco_empresa_bolsa id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.balanco_empresa_bolsa ALTER COLUMN id SET DEFAULT nextval('public.balanco_empresa_bolsa_id_seq'::regclass);


--
-- Name: categoria id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categoria ALTER COLUMN id SET DEFAULT nextval('public.categoria_id_seq'::regclass);


--
-- Name: operacao id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.operacao ALTER COLUMN id SET DEFAULT nextval('public.operacao_id_seq'::regclass);


--
-- Name: tipo id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tipo ALTER COLUMN id SET DEFAULT nextval('public.tipo_id_seq'::regclass);


--
-- Data for Name: acao_bolsa; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.acao_bolsa (id, nome, codigo, setor, cnpj) FROM stdin;
1	Alliar	AALR3	Medicina Diagnóstica	42.771.949/0001-35
2	Banco ABC	ABCB4	Bancos	28.195.667/0001-06
3	Ambev	ABEV3	Bebidas	07.526.557/0001-00
4	Advanced Digital Health	ADHM3	Medicina Diagnóstica	10.345.009/0001-98
5	Afluente T	AFLT3	Energia	10.338.320/0001-00
6	BrasilAgro	AGRO3	Agricultura	07.628.528/0001-59
7	Aliansce	ALSC3	Shoppings	06.082.980/0001-03
8	Lojas Marisa	AMAR3	Vestuário	61.189.288/0001-89
9	Anima	ANIM3	Educação	09.288.252/0001-32
10	Arezzo	ARZZ3	Calçados	16.590.234/0001-76
11	Atom	ATOM3	Mesa Proprietária de Traders	00.359.742/0001-08
12	Azul	AZUL4	Aéreo	09.305.994/0001-29
13	B3	B3SA3	Bolsa de Valores	09.346.601/0001-25
14	Bahema	BAHI3	Educação	45.987.245/0001-92
15	Banco da Amazônia	BAZA3	Bancos	04.902.979/0001-44
16	Banco do Brasil	BBAS3	Bancos	00.000.000/0001-91
17	Brasil Brokers	BBRK3	Exploração de Imóveis	08.613.550/0001-98
18	BB Seguridade	BBSE3	Seguros	17.344.597/0001-94
19	Minerva	BEEF3	Carnes e Derivados	67.620.377/0001-14
20	Banco Inter	BIDI4	Bancos	00.416.968/0001-01
21	Biomm	BIOM3	Medicamentos	04.752.991/0001-10
22	Burger King	BKBR3	Restaurantes	13.574.594/0001-96
23	Monark	BMKS3	Bicicletas	56.992.423/0001-90
24	Banco do Nordeste	BNBR3	Bancos	07.237.373/0001-20
25	Banco Pan	BPAN4	Bancos	59.285.411/0001-13
26	BR Pharma	BPHA3	Produtos Farmacêuticos	11.395.624/0001-71
27	BR Distribuidora	BRDT3	Petróleo, Gás e Biocombustíveis	34.274.233/0001-02
28	BRF	BRFS3	Carnes e Derivados	01.838.723/0001-27
29	Brasil Insurance	BRIN3	Seguros	11.721.921/0001-60
30	BR Malls	BRML3	Shoppings	06.977.745/0001-91
31	BRProperties	BRPR3	Exploração de Imóveis	06.977.751/0001-49
32	Biosev	BSEV3	Açúcar e Álcool	15.527.906/0001-36
33	B2W Digital	BTOW3	Comércio Varejista	00.776.574/0001-56
34	Camil	CAML3	Alimentos	64.904.295/0001-03
35	CSU Cardsystem	CARD3	Software	01.896.779/0001-38
36	Ampla Energia	CBEE3	Energia	33.050.071/0001-58
37	Cyrela Commercial	CCPR3	Exploração de Imóveis	08.801.621/0001-86
38	CCR	CCRO3	Exploração de Rodovias	02.846.056/0001-97
39	CCX Carvão	CCXC3	Mineração	07.950.674/0001-04
40	Ceg	CEGR3	Gás	33.938.119/0001-69
41	Cielo	CIEL3	Meios de Pagamento	01.027.058/0001-91
42	Centauro	CNTO3	Vestuário	13.217.485/0001-11
43	CPFL Energia	CPFE3	Energia	02.429.144/0001-93
44	CPFL Renováveis	CPRE3	Energia	08.439.659/0001-50
45	CR2	CRDE3	Construção Civil	07.820.907/0001-46
46	Carrefour	CRFB3	Comércio Varejista	75.315.333/0001-09
47	Cosan	CSAN3	Petróleo, Gás e Biocombustíveis	50.746.577/0001-15
48	Copasa	CSMG3	Saneamento	17.281.106/0001-03
49	CSN	CSNA3	Siderurgia	33.042.730/0001-04
50	CVC	CVCB3	Viagens e Turismo	10.760.260/0001-19
51	Cyrela Realty	CYRE3	Construção Civil	73.178.600/0001-18
52	Dasa	DASA3	Medicina Diagnóstica	61.486.650/0001-83
53	Direcional	DIRR3	Construção Civil	16.614.075/0001-00
54	Dommo	DMMO3	Petróleo, Gás e Biocombustíveis	08.926.302/0001-05
55	Duratex	DTEX3	Produtos para Construção Civil	97.837.181/0001-47
56	Ecorodovias	ECOR3	Exploração de Rodovias	04.149.454/0001-80
57	Engie	EGIE3	Energia	02.474.103/0001-19
58	Eletropaulo	ELPL3	Energia	61.695.227/0001-93
59	Embraer	EMBR3	Produção de Aerovanes	07.689.002/0001-89
60	Enauta	ENAT3	Petróleo, Gás e Biocombustíveis	11.669.021/0001-10
61	Energias do Brasil	ENBR3	Energia	03.983.431/0001-03
62	Eneva	ENEV3	Energia	04.423.567/0001-21
63	Equatorial	EQTL3	Energia	03.220.438/0001-73
64	Estácio	ESTC3	Educação	08.807.432/0001-10
65	Eternit	ETER3	Produtos para Construção Civil	61.092.037/0001-81
66	Even	EVEN3	Construção Civil	43.470.988/0001-65
67	Eztec	EZTC3	Construção Civil	08.312.229/0001-73
68	Heringer	FHER3	Fertilizantes	22.266.175/0001-88
69	Fleury	FLRY3	Medicina Diagnóstica	60.840.055/0001-31
70	Fras-le	FRAS3	Material Rodoviário	88.610.126/0001-29
71	Metalfrio	FRIO3	Máquinas e Equipamentos	04.821.041/0001-08
72	Pomi Frutas	FRTA3	Agricultura	86.550.951/0001-50
73	Biotoscana	GBIO33	Medicamentos	19.688.956/0001-56
74	Gafisa	GFSA3	Construção Civil	01.545.826/0001-07
75	NotreDame Intermédica	GNDI3	Seguros	19.853.511/0001-84
76	Celg	GPAR3	Energia	08.560.444/0001-93
77	GP Investments	GPIV33	Gestão de Recursos	07.857.850/0001-50
78	Grendene	GRND3	Calçados	89.850.341/0001-60
79	General Shopping	GSHP3	Shoppings	08.764.621/0001-53
80	Guararapes	GUAR3	Vestuário	08.402.943/0001-52
81	Hapvida	HAPV3	Seguros	05.197.443/0001-38
82	Helbor	HBOR3	Construção Civil	49.263.189/0001-02
83	Cia Hering	HGTX3	Vestuário	78.876.950/0001-71
84	Hypera Pharma	HYPE3	Medicamentos	02.932.074/0001-91
85	Ideiasnet	IDNT3	Holding	02.365.069/0001-44
86	IGB Eletrônica	IGBR3	Eletrodomésticos	43.185.362/0001-07
87	Iguatemi	IGTA3	Shoppings	51.218.147/0001-93
88	IRB Brasil	IRBR3	Seguros	33.376.989/0001-91
89	Itautec	ITEC3	Tecnologia Bancária	54.526.082/0001-31
90	JBS	JBSS3	Carnes e Derivados	02.916.265/0001-60
91	João Fortes	JFEN3	Construção Civil	33.035.536/0001-00
92	JHSF	JHSF3	Shoppings e Hotelaria	08.294.224/0001-65
93	Jereissati	JPSA3	Exploração de Imóveis	60.543.816/0001-93
94	JSL	JSLG3	Logísitica e Rodoviário	52.548.435/0001-79
95	Kepler	KEPL3	Máquinas e Equipamentos	91.983.056/0001-69
96	Kroton	KROT3	Educação	02.800.026/0001-40
97	Locamérica	LCAM3	Aluguel e Venda de Carros	10.215.988/0001-60
98	Mahle Metal Leve	LEVE3	Peças para Motores	60.476.884/0001-87
99	Light	LIGT3	Energia	03.378.521/0001-75
100	Linx	LINX3	Software	06.948.969/0001-75
101	Eletropar	LIPR3	Energia	01.104.937/0001-70
102	Liq	LIQO3	Consultoria	04.032.433/0001-80
103	Le Lis Blanc	LLIS3	Vestuário	49.669.856/0001-43
104	Log CP	LOGG3	Construção Civil	09.041.168/0001-10
105	Log-in	LOGN3	Hidroviário	42.278.291/0001-24
106	Lopes Brasil	LPSB3	Exploração de Imóveis	08.078.847/0001-09
107	Lojas Renner	LREN3	Vestuário	92.754.738/0001-62
108	Lupatech	LUPA3	Equipamentos e Petróleo	89.463.822/0001-12
109	M.Dias Branco	MDIA3	Alimentos	07.206.816/0001-15
110	International Meal	MEAL3	Restaurantes	17.314.329/0001-20
111	Magazine Luiza	MGLU3	Comércio Varejista	47.960.950/0001-21
112	Mills	MILS3	Construção e Engenharia	27.093.558/0001-15
113	MMX Miner	MMXM3	Mineração	02.762.115/0001-49
114	Mundial	MNDL3	Utensílios Pessoais e Domésticos	88.610.191/0001-54
115	Minupar	MNPR3	Carnes e Derivados	90.076.886/0001-40
116	Monteiro Aranha	MOAR3	Holding	33.102.476/0001-92
117	Movida	MOVI3	Aluguel e Venda de Carros	21.314.559/0001-66
118	Multiplus	MPLU3	Programas de Fidelidade	11.094.546/0001-75
119	Marfrig	MRFG3	Carnes e Derivados	03.853.896/0001-40
120	MRV Engenharia	MRVE3	Construção Civil	08.343.492/0001-20
121	Multiplan	MULT3	Shoppings	07.816.890/0001-53
122	Iochpe-Maxion	MYPK3	Automotivo	61.156.113/0001-75
123	Natura	NATU3	Cosméticos	71.673.990/0001-77
124	Nordon	NORD3	Máquinas e Equipamentos	60.884.319/0001-59
125	Odontoprev	ODPV3	Seguros	58.119.199/0001-51
126	Ouro Fino	OFSA3	Medicamentos	20.258.278/0001-70
127	Omega Geração	OMGE3	Energia	09.149.503/0001-06
128	OSX Brasil	OSXB3	Petróleo, Gás e Biocombustíveis	09.112.685/0001-32
129	Hermes Pardini	PARD3	Medicina Diagnóstica	19.378.769/0001-76
130	PDG Realty	PDGR3	Construção Civil	02.950.811/0001-89
131	Profarma	PFRM3	Produtos Farmacêuticos	45.453.214/0001-51
132	Plascar	PLAS3	Automotivo	51.928.174/0001-50
133	Paranapanema	PMAM3	Siderurgia	60.398.369/0004-79
134	Positivo	POSI3	Hardware	81.243.735/0001-48
135	Petrorio	PRIO3	Petróleo, Gás e Biocombustíveis	10.629.105/0001-68
136	Porto Seguro	PSSA3	Seguros	02.149.205/0001-69
137	Portobello	PTBL3	Cerâmicos	83.475.913/0001-91
138	Qualicorp	QUAL3	Seguros	11.992.680/0001-93
139	RaiaDrogasil	RADL3	Produtos Farmacêuticos	61.585.865/0001-51
140	Rumo Log	RAIL3	Logística e Ferroviário	02.387.241/0001-60
141	RNI	RDNI3	Construção Civil	67.010.660/0001-24
142	Rede Energia	REDE3	Petróleo, Gás e Biocombustíveis	61.584.140/0001-49
143	Localiza	RENT3	Aluguel e Venda de Carros	16.670.085/0001-55
144	Cosan Logística	RLOG3	Logística e Ferroviário	17.346.997/0001-39
145	Indústrias Romi	ROMI3	Máquinas e Equipamentos	56.720.428/0001-63
146	PET Manguinhos	RPMG3	Petróleo, Gás e Biocombustíveis	33.412.081/0001-96
147	Rossi	RSID3	Construção Civil	61.065.751/0001-80
148	Sabesp	SBSP3	Saneamento	43.776.517/0001-80
149	São Carlos	SCAR3	Exploração de Imóveis	29.780.061/0001-09
150	Somos Educação	SEDU3	Educação	02.541.982/0001-54
151	SER Educacional	SEER3	Educação	04.986.320/0001-13
152	Springs Global	SGPS3	Têxtil	07.718.269/0001-57
153	Time For Fun	SHOW3	Eventos e Shows	02.860.694/0001-62
154	SLC Agrícola	SLCE3	Agricultura	89.096.457/0001-55
155	Smiles	SMLS3	Programas de Fidelidade	05.730.375/0001-20
156	São Martinho	SMTO3	Açúcar e Álcool	51.466.860/0001-56
157	Sinqia	SQIA3	Software	04.065.791/0001-99
158	Sierra Brasil	SSBR3	Shoppings	05.878.397/0001-32
159	Santos Brasil	STBP3	Logística e Portuário	02.762.121/0001-04
160	Suzano Papel	SUZB3	Papel e Celulose	16.404.287/0001-55
161	Tecnisa	TCSA3	Construção Civil	08.065.557/0001-12
162	Technos	TECN3	Relógios	09.295.063/0001-97
163	Tenda	TEND3	Construção Civil	71.476.527/0001-35
164	Terra Santa	TESA3	Agricultura	05.799.312/0001-20
165	Tegma	TGMA3	Automotivo e Logística	02.351.144/0001-18
166	TIM	TIMP3	Telecomunicações	02.558.115/0001-21
167	Totvs	TOTS3	Software	53.113.791/0001-22
168	Triunfo	TPIS3	Exploração de Rodovias	03.014.553/0001-91
169	Trisul	TRIS3	Construção Civil	08.811.643/0001-27
170	Tarpon	TRPN3	Gestão de Recursos	05.341.549/0001-63
171	Tupy	TUPY3	Material Rodoviário	84.683.374/0001-49
172	Unicasa	UCAS3	Móveis	90.441.460/0001-48
173	Ultrapar	UGPA3	Petróleo, Gás e Biocombustíveis	33.256.439/0001-39
174	Vale	VALE3	Mineração	33.592.510/0001-54
175	Viver	VIVR3	Construção Civil	67.571.414/0001-41
176	Valid	VLID3	Documentos de Segurança	33.113.309/0001-47
177	Vulcabras	VULC3	Calçados	50.926.955/0001-42
178	Via Varejo	VVAR3	Comércio Varejista	33.041.260/0652-90
179	Weg	WEGE3	Motores e Compressores	84.429.695/0001-11
180	WIZ Soluções	WIZS3	Seguros	42.278.473/0001-03
181	Wilson Sons	WSON33	Logística	05.721.735/0001-28
182	São Paulo Turismo	AHEB3, AHEB5 e AHEB6	Eventos e Shows	62.002.886/0001-60
183	Alpargatas	ALPA3 e ALPA4	Calçados	61.079.117/0001-05
184	Alupar	ALUP3, ALUP4 e ALUP11	Energia	08.364.948/0001-38
185	Azevedo Travassos	AZEV3 e AZEV4	Construção Civil	61.351.532/0001-68
186	Baumer	BALM3 e BALM4	Implantes Ortopédicos	61.374.161/0001-30
187	Excelsior	BAUH3 e BAUH4	Carnes e Derivados	95.426.862/0001-97
188	Banco Bradesco	BBDC3 e BBDC4	Bancos	60.746.948/0001-12
189	Bardella	BDLL3 e BDLL4	Máquinas e Equipamentos	60.851.615/0001-53
190	Banestes	BEES3 e BEES4	Bancos	28.127.603/0001-78
191	Banese	BGIP3 e BGIP4	Bancos	13.009.717/0001-46
192	Banco Mercantil	BMEB3 e BMEB4	Bancos	17.184.037/0001-10
193	Mercantil Investimentos	BMIN3 e BMIN4	Bancos	34.169.557/0001-72
194	Bombril	BOBR3 e BOBR4	Produtos de Limpeza	50.564.053/0001-03
195	Banco BTG Pactual	BPAC3, BPAC5 e BPAC11	Bancos	30.306.294/0001-45
196	Bradespar	BRAP3 e BRAP4	Holding	03.847.461/0001-92
197	Alfa Consórcio	BRGE3, 5, 6, 7, 8, 11 e 12	Seguros	17.193.806/0001-46
198	Banco Alfa	BRIV3 e BRIV4	Bancos	60.770.336/0001-65
199	Braskem	BRKM3, BRKM5 e BRKM6	Químicos	42.150.391/0001-70
200	Banrisul	BRSR3, BRSR5 e BRSR6	Bancos	92.702.067/0001-96
201	Banco de Brasília	BSLI3 e BSLI4	Bancos	00.000.208/0001-00
202	Battistella	BTTL3 e BTTL4	Holding	42.331.462/0001-31
203	Adolpho Lindenberg	CALI3 e CALI4	Construção Civil	61.022.042/0001-18
204	Cambuci	CAMB3 e CAMB4	Calçados	61.088.894/0001-08
205	Casan	CASN3 e CASN4	Saneamento	82.508.433/0001-17
206	Cia Energética de Brasília	CEBR3, CEBR5 e CEBR6	Energia	00.070.698/0001-11
207	Cedro Têxtil	CEDO3 e CEDO4	Têxtil	17.245.234/0001-00
208	Coelba	CEEB3, CEEB5 e CEEB6	Energia	15.139.629/0001-94
209	CEEE	CEED3 e CEED4	Energia	08.467.115/0001-00
210	Celpa	CELP3, CELP5, CELP6 e CELP7	Energia	04.895.728/0001-80
211	Celpe	CEPE3, CEPE5 e CEPE6	Energia	10.835.932/0001-08
212	Cesp	CESP3, CESP5 e CESP6	Energia	60.933.603/0001-78
213	Comgás	CGAS3 e CGAS5	Gás	61.856.571/0001-17
214	Grazziotin	CGRA3 e CGRA4	Vestuário	92.012.467/0001-70
215	Celesc	CLSC3 e CLSC4	Energia	83.878.892/0001-55
216	Cemig	CMIG3 e CMIG4	Energia	17.155.730/0001-64
217	Coelce	COCE3, COCE5 e COCE6	Energia	07.047.251/0001-70
218	Copel	CPLE3, CPLE5 e CPLE6	Energia	76.483.817/0001-20
219	Alfa Financeira	CRIV3 e CRIV4	Financeira	17.167.412/0001-13
220	Cristal	CRPG3, CRPG5 e CRPG6	Químicos	15.115.504/0001-24
221	Seguro Aliança	CSAB3 e CSAB4	Seguros	15.144.017/0001-90
222	Cosern	CSRN3, CSRN5 e CSRN6	Energia	08.324.196/0001-81
223	Karsten	CTKA3 e CTKA4	Têxtil	82.640.558/0001-04
224	Coteminas	CTNM3 e CTNM4	Têxtil	22.677.520/0001-76
225	Santanense	CTSA3, CTSA4 e CTSA8	Têxtil	21.255.567/0001-89
226	Dohler	DOHL3 e DOHL4	Têxtil	84.683.408/0001-03
227	DTCOM	DTCY3 e DTCY4	Educação	03.303.999/0001-36
228	Electro Aço Altona	EALT3 e EALT4	Máquinas e Equipamentos	82.643.537/0001-34
229	CEEE-GT	EEEL3 e EEEL4	Energia	92.715.812/0001-31
230	Elektro	EKTR3 e EKTR4	Energia	02.328.280/0001-97
231	Elekeiroz	ELEK3 e ELEK4	Químicos	13.788.120/0001-47
232	Eletrobras	ELET3, ELET5 e ELET6	Energia	00.001.180/0001-26
233	Emae	EMAE3 e EMAE4	Energia	02.302.101/0001-42
234	Energisa	ENGI3, ENGI4 e ENGI11	Energia	00.864.214/0001-06
235	Energisa MT	ENMT3 e ENMT4	Energia	03.467.321/0001-99
236	Estrela	ESTR3 e ESTR4	Brinquedos e Jogos	61.082.004/0001-50
237	Eucatex	EUCA3 e EUCA4	Madeira	56.643.018/0001-66
238	Ferbasa	FESA3 e FESA4	Siderurgia	15.141.799/0001-03
239	Forja Taurus	FJTA3 e FJTA4	Armas e Equipamentos	92.781.335/0001-02
240	Paranapanema Energia	GEPA3 e GEPA4	Energia	02.998.301/0001-81
241	Gerdau	GGBR3 e GGBR4	Siderurgia	33.611.500/0001-19
242	Metalúrgica Gerdau	GOAU3 e GOAU4	Siderurgia	92.690.783/0001-09
243	Gol	GOLL3 e GOLL4	Aéreo	06.164.253/0001-87
244	GPC	GPCP3 e GPCP4	Químicos	02.193.750/0001-52
245	Haga	HAGA3 e HAGA4	Produtos para Construção Civil	30.540.991/0001-66
246	Habitasul	HBTS3, HBTS5 e HBTS6	Exploração de Imóveis	87.762.563/0001-03
247	Hercules	HETA3 e HETA4	Utensílios Pessoais e Domésticos	92.749.225/0001-63
248	Hotéis Othon	HOOT3 e HOOT4	Hotelaria	33.200.049/0001-47
249	Banco Indusval	IDVL3 e IDVL4	Bancos	61.024.352/0001-71
250	Inepar	INEP3 e INEP4	Máquinas e Equipamentos	76.627.504/0001-06
251	Itaúsa	ITSA3 e ITSA4	Holding	61.532.644/0001-15
252	Banco Itaú	ITUB3 e ITUB4	Bancos	60.872.504/0001-23
253	JB Duarte	JBDU3 e JBDU4	Holding	60.637.238/0001-54
254	Josapar	JOPA3 e JOPA4	Alimentos	87.456.562/0001-22
255	Klabin	KLBN3, KLBN4 e KLBN11	Papel e Celulose	89.637.490/0001-45
256	Lojas Americanas	LAME3 e LAME4	Comércio Varejista	33.014.556/0001-96
257	Trevisa	LUXM3 e LUXM4	Fertilizantes	92.660.570/0001-26
258	Cemepe Investimentos	MAPT3 e MAPT4	Holding	93.828.986/0001-73
259	Mendes Júnior	MEND3, MEND5 e MEND6	Construção Civil	17.162.082/0001-73
260	Mercantil Financeira	MERC3 e MERC4	Financeira	33.040.601/0001-87
261	Magnels	MGEL3 e MGEL4	Siderurgia	61.065.298/0001-02
262	Melhoramentos SP	MSPA3 e MSPA4	Papel e Celulose e Editorial	60.730.348/0001-66
263	Metalgráfica Iguaçu	MTIG3 e MTIG4	Embalagens	80.227.184/0001-66
264	Metisa	MTSA3 e MTSA4	Máquinas e Equipamentos	86.375.425/0001-09
265	Wetzel	MWET3 e MWET4	Automotivo	84.683.671/0001-94
266	Oderich	ODER3 e ODER4	Alimentos	97.191.902/0001-94
267	Oi	OIBR3 e OIBR4	Telecomunicações	76.535.764/0001-43
268	Panatlântica	PATI3 e PATI4	Siderurgia	92.693.019/0001-89
269	Pão de Açucar	PCAR3 e PCAR4	Comércio Varejista	47.508.411/0001-56
270	Participações Aliança	PEAB3 e PEAB4	Holding	01.938.783/0001-11
271	Petrobras	PETR3 e PETR4	Petróleo, Gás e Biocombustíveis	33.000.167/0001-01
272	Banco Pine	PINE3 e PINE4	Bancos	62.144.175/0001-20
273	Dimed	PNVL3 e PNVL4	Medicamentos	92.665.611/0001-77
274	Marcopolo	POMO3 e POMO4	Material Rodoviário	88.611.835/0001-29
275	Pettenati	PTNT3 e PTNT4	Têxtil	88.613.658/0001-10
276	Celulose Irani	RANI3 e RANI4	Papel e Celulose	92.791.243/0001-03
277	Randon	RAPT3 e RAPT4	Material Rodoviário	89.086.144/0001-16
278	Recrusul	RCSL3 e RCSL4	Material Rodoviário	91.333.666/0001-17
279	Renova	RNEW3, RNEW4 e RNEW11	Energia	08.534.605/0001-74
280	Alfa Holdings	RPAD3, RPAD5 e RPAD6	Holding	17.167.396/0001-69
281	Riosulense	RSUL3 e RSUL4	Metalurgia	85.778.074/0001-06
282	Santander	SANB3, SANB4 e SANB11	Bancos	90.400.888/0001-42
283	Sanepar	SAPR3, SAPR4 e SAPR11	Saneamento	76.484.013/0001-45
284	Schulz	SHUL3 e SHUL4	Automotivo e Compressores	84.693.183/0001-68
285	Saraiva	SLED3 e SLED4	Comércio Varejista	60.500.139/0001-26
286	Smart Fit	SMFT3, 6, 11, 12, 13, 14, 15	Academias	07.594.978/0001-78
287	Sondotécnica	SOND3, SOND5 e SOND6	Consultoria e Engenharia	33.386.210/0001-19
288	Springer	SPRI3 e SPRI4	Eletrodomésticos	92.929.520/0001-00
289	Sulamerica	SULA3, SULA4 e SULA11	Seguros	29.978.814/0001-87
290	Taesa	TAEE3, TAEE4 e TAEE11	Energia	07.859.971/0001-30
291	Tecnosolo	TCNO3 e TCNO4	Consultoria e Engenharia	33.111.246/0001-90
292	Teka	TEKA3 e TEKA4	Têxtil	82.636.986/0001-55
293	Telebrás	TELB3 e TELB4	Telecomunicações	00.336.701/0001-04
294	AES Tietê	TIET3, TIET4 e TIET11	Energia	04.128.563/0001-10
295	Tekno	TKNO3 e TKNO4	Siderurgia	33.467.572/0001-34
296	Tectoy	TOYB3 e TOYB4	Brinquedos e Jogos	22.770.366/0001-82
297	Trans Paulista	TRPL3 e TRPL4	Energia	02.998.611/0001-04
298	Renauxview	TXRX3 e TXRX4	Vestuário	82.982.075/0001-80
299	Unipar	UNIP3, UNIP5 e UNIP6	Soda, Cloro e Derivados	33.958.695/0001-78
300	Usiminas	USIM3, USIM5 e USIM6	Siderurgia	60.894.730/0001-05
301	Telefônica	VIVT3 e VIVT4	Telecomunicações	02.558.157/0001-62
302	Whirlpool	WHRL3 e WHRL4	Eletrodomésticos	59.105.999/0001-86
303	WLM	WLMM3 e WLMM4	Automotivo e Agropecuário	33.228.024/0001-51
\.


--
-- Data for Name: ativo; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.ativo (id, nome, codigo, quantidade, valor_compra, valor_bruto, valor_liquido, tipo_id, categoria_id, ativo, acao_bolsa_id) FROM stdin;
15	Itausa	ITSA4	0	0	0	0	7	2	f	\N
21	weg	WEGE3	58	1349.76001	2027.09998	2027.09998	7	2	t	179
25	Odonto Prev	ODPV3	99	1588.28003	1657.26001	1657.26001	7	2	t	125
14	Banco inter	BIDI4	105	1501.83997	1828.05005	1828.05005	7	2	t	20
20	fleury	FLRY3	59	1422.05005	1855.55005	1855.55005	7	2	t	69
23	Grendene	GRND3	162	1268.01001	2057.3999	2057.3999	7	2	t	78
13	ALASKA BLACK FIC FIA II	ALASKA BLACK FIC FIA II	0	0	0	0	3	2	f	\N
19	engie	EGIE3	35	1620.29004	1818.59998	1818.59998	7	2	t	57
6	BANCO AGIBANK - 121.50% - 31/07/2020	BANCO AGIBANK - 121.50%-31/07/2020	2	2000	2212.87988	2175.62988	4	1	t	\N
2	CMDT23 - CEMIG DISTRIBUICAO S.A  IPC-A + 9.15%	CMDT23 - CEMIG DISTRIBUICAO S.A - IPC-A + 9.15%	1	1198.48999	990.26001	945.359985	6	1	t	\N
7	CMDT23 - CEMIG DISTRIBUICAO S.A - IPCA - 9.70	CMDT23 - CEMIG DISTRIBUICAO S.A - IPCA - 9.70%	1	1217.93005	993.150024	952.570007	6	1	t	\N
9	Banco Maxima - 121% CDI	Banco Maxima - 121% CDI	2	2000	2125.44995	2100.36011	4	1	t	\N
10	Banco Maxima - 128% CDI - 21/07/2023	Banco Maxima - 128% CDI - 21/07/2023	1	1000	1109.64001	1090.44995	4	1	t	\N
11	Banco Maxima - 128% CDI - 28/01/2026	Banco Maxima - 128% CDI	1	1000	1063.10999	1050.48999	4	1	t	\N
12	DEVANT SOLIDUS CASH FIRF CP	DEVANT SOLIDUS CASH FIRF CP	0.911199987	1190	1228.08997	1226.06995	3	1	t	\N
17	ambev	ABEV3	87	1575.14001	1663.43994	1663.43994	7	2	t	3
18	B3	B3SA3	31	1300.92004	1384.77002	1384.77002	7	2	t	13
16	Itausa	ITSA3	122	1656.71997	1700.68005	1700.68005	7	2	t	251
24	M.Dias Branco	MDIA3	49	1782.64001	1913.44995	1913.44995	7	2	t	109
1	Tesouro Selic 2023	Tesouro Selic 2023	0.360000014	3501.51001	3770.08008	3722.51001	2	1	t	\N
3	Tesouro IPCA+ 2024	Tesouro IPCA+ 2024	3.3499999	7399.45996	9869.62012	9474.67969	2	1	t	\N
4	Tesouro Selic 2025	Tesouro Selic 2025	1.32000005	13353.5996	14752.6797	14655.9004	2	1	t	\N
5	BANCO AGIBANK - 121.50% - 20/04/2020	BANCO AGIBANK - 121.50% - 20/04/2020	2	2000	2259.62012	2214.18994	4	1	t	\N
\.


--
-- Data for Name: balanco_empresa_bolsa; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.balanco_empresa_bolsa (id, cnpj, tag_along_on, free_float_on, governo, data, patrimonio_liquido, receita_liquida, ebitda, da, ebit, margem_ebit, resultado_financeiro, imposto, lucro_liquido, margem_liquida, roe, caixa, divida_bruta, divida_liquida, divida_bruta_patrimonio, divida_liquida_ebitda, fco, capex, fcf, fcl, capex_fco, proventos, payout, anual) FROM stdin;
\.


--
-- Data for Name: categoria; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.categoria (id, nome) FROM stdin;
2	Renda Variável
1	Renda Fixa
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
\.


--
-- Data for Name: operacao; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.operacao (id, quantidade, valor, data, ativo_id, tipo) FROM stdin;
3	100	1241	2019-06-04 00:00:00	15	1
15	1	1217.93005	2017-02-13 00:00:00	7	1
16	1	1198.48999	2017-04-24 00:00:00	2	1
17	2	2000	2019-02-18 00:00:00	9	1
18	1	1000	2018-08-16 00:00:00	10	1
19	1	1000	2019-06-06 00:00:00	11	1
10	3.3499999	7399.45996	2019-06-20 00:00:00	3	1
12	1.31120002	2290	2019-06-20 00:00:00	12	1
9	1.03999996	10433.0996	2019-06-20 00:00:00	4	1
8	0.360000014	3501.51001	2019-06-20 00:00:00	1	1
20	2	2000	2019-07-03 00:00:00	6	1
13	2	2000	2018-04-26 00:00:00	5	1
2	48	531.200012	2019-06-04 00:00:00	14	1
21	0.0199999996	202	2019-07-04 00:00:00	4	1
11	1	3000	2019-06-20 00:00:00	13	1
23	100	1358	2019-07-10 00:00:00	16	1
24	43	991.580017	2019-07-24 00:00:00	21	1
25	39	928.97998	2019-07-24 00:00:00	20	1
26	55	995.5	2019-07-24 00:00:00	17	1
27	24	1000.08002	2019-07-24 00:00:00	18	1
28	21	989.52002	2019-07-24 00:00:00	19	1
29	1	3892.90991	2019-07-19 00:00:00	13	0
30	26	201.5	2019-07-25 00:00:00	23	1
31	13	513.23999	2019-08-02 00:00:00	24	1
32	58	435	2019-08-02 00:00:00	23	1
33	0.400000006	1100	2019-08-07 00:00:00	12	0
66	3	48.7200012	2019-08-13 00:00:00	25	1
70	55	897.599976	2019-08-16 00:00:00	25	1
72	8	297.359985	2019-08-16 00:00:00	24	1
73	1	7.30000019	2019-08-16 00:00:00	23	1
76	5	36.9500008	2019-08-26 00:00:00	23	1
79	4	91.2799988	2019-09-03 00:00:00	21	1
80	5	100.800003	2019-09-03 00:00:00	14	1
81	5	120.300003	2019-09-03 00:00:00	20	1
82	3	133.679993	2019-09-03 00:00:00	19	1
83	9	321.119995	2019-09-03 00:00:00	24	1
84	49	380.23999	2019-09-03 00:00:00	23	1
86	5	87.8000031	2019-09-10 00:00:00	14	1
88	8	64	2019-09-10 00:00:00	23	1
89	2	74.0999985	2019-09-10 00:00:00	24	1
90	5	115.849998	2019-09-10 00:00:00	21	1
91	7	132.580002	2019-09-10 00:00:00	17	1
92	6	141.419998	2019-09-10 00:00:00	20	1
94	16	252.960007	2019-09-10 00:00:00	25	1
95	1	8.47999954	2019-10-02 00:00:00	23	1
96	1	18.9300003	2019-10-02 00:00:00	17	1
97	1	42.9599991	2019-10-02 00:00:00	18	1
98	1	25.2700005	2019-10-02 00:00:00	20	1
99	3	38.1300011	2019-10-02 00:00:00	16	1
100	3	47.1599998	2019-10-02 00:00:00	25	1
102	4	70.1999969	2019-10-02 00:00:00	14	1
103	3	72.4199982	2019-10-02 00:00:00	21	1
105	6	209.639999	2019-10-02 00:00:00	24	1
106	5	220.050003	2019-10-02 00:00:00	19	1
108	14	238.419998	2019-11-04 00:00:00	14	1
111	6	83.3399963	2019-11-04 00:00:00	16	1
112	2	92.3199997	2019-11-04 00:00:00	19	1
113	8	206.080002	2019-11-04 00:00:00	20	1
114	14	215.039993	2019-11-04 00:00:00	25	1
110	3	78.6299973	2019-11-04 00:00:00	21	1
109	17	295.619995	2019-11-04 00:00:00	17	1
93	11	193.160004	2019-09-10 00:00:01	14	1
104	7	132.509995	2019-10-02 00:00:01	17	1
107	6	257.880005	2019-10-02 00:00:01	18	1
87	8	126.800003	2019-09-10 00:00:01	25	1
77	1	7.80999994	2019-09-03 00:00:01	23	1
101	7	59.3600006	2019-10-02 00:00:01	23	1
78	1	44.5	2019-09-03 00:00:01	19	1
85	1	12.9700003	2019-09-10 00:00:00	16	1
129	1	11.3199997	2019-12-05 10:09:23	23	1
130	18	280.26001	2019-12-05 10:08:38	14	1
131	5	56.0499992	2019-12-05 10:05:34	23	1
132	3	140.220001	2019-12-05 10:04:08	19	1
133	12	164.279999	2019-12-05 10:03:17	16	1
134	11	367.179993	2019-12-05 10:02:24	24	1
22	100	1341	2019-07-10 00:00:00	15	0
135	0.119999997	1255.76001	2020-01-03 10:05:00	4	1
136	0.0900000036	941.5	2019-12-30 10:50:00	4	1
137	0.0500000007	521.289978	2019-12-03 10:10:00	4	1
\.


--
-- Data for Name: tipo; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tipo (id, nome) FROM stdin;
3	Fundos de investomento
4	CDB
6	Debêntures
7	Ações
2	Tesouro direto 
\.


--
-- Name: acao_bolsa_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.acao_bolsa_id_seq', 303, true);


--
-- Name: ativo_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.ativo_id_seq', 25, true);


--
-- Name: balanco_empresa_bolsa_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.balanco_empresa_bolsa_id_seq', 1, false);


--
-- Name: categoria_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.categoria_id_seq', 2, true);


--
-- Name: operacao_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.operacao_id_seq', 137, true);


--
-- Name: tipo_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tipo_id_seq', 7, true);


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
-- Name: balanco_empresa_bolsa balanco_empresa_bolsa_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.balanco_empresa_bolsa
    ADD CONSTRAINT balanco_empresa_bolsa_pkey PRIMARY KEY (id);


--
-- Name: categoria categoria_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categoria
    ADD CONSTRAINT categoria_pkey PRIMARY KEY (id);


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
-- Name: tipo tipo_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tipo
    ADD CONSTRAINT tipo_pkey PRIMARY KEY (id);


--
-- Name: ativo_data_operacao; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX ativo_data_operacao ON public.operacao USING btree (ativo_id, data);


--
-- Name: unique_balanco_cnpj; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX unique_balanco_cnpj ON public.balanco_empresa_bolsa USING btree (cnpj);


--
-- Name: unique_cnpj; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX unique_cnpj ON public.acao_bolsa USING btree (cnpj);


--
-- Name: ativo ativo_acao_bolsa_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ativo
    ADD CONSTRAINT ativo_acao_bolsa_id_fkey FOREIGN KEY (acao_bolsa_id) REFERENCES public.acao_bolsa(id);


--
-- Name: ativo ativo_categoria_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ativo
    ADD CONSTRAINT ativo_categoria_id_fkey FOREIGN KEY (categoria_id) REFERENCES public.categoria(id);


--
-- Name: ativo ativo_tipo_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ativo
    ADD CONSTRAINT ativo_tipo_id_fkey FOREIGN KEY (tipo_id) REFERENCES public.tipo(id);


--
-- Name: operacao operacao_ativo_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.operacao
    ADD CONSTRAINT operacao_ativo_id_fkey FOREIGN KEY (ativo_id) REFERENCES public.ativo(id);


--
-- PostgreSQL database dump complete
--

