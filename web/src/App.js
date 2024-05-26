import { theme, GlobalStyles } from "./styles";

import AppContext from "services/context";

import axios from "axios";
import Button from "components/Button";
import Header from "components/Header";
import Input from "components/Input";
import { useFormik } from "formik";
import parse from "html-react-parser";
import React, { useState } from "react";
import { useEffect } from "react";
import { ThemeProvider } from "styled-components";

const axiosClient = axios.create({
  baseURL: process.env.REACT_APP_API_URL,
  headers: {
    "Content-Type": "application/json",
    Accept: "application/json",
  },
});

function App() {
  const 
    [posts, setPosts] = useState([]),
    [settings, setSettings] = useState([]),
    formik = useFormik({
      initialValues: {
        name: "",
        email: "",
        subject: "",
        message: "",
      },
      onSubmit: (values) => {
        console.log(values);
        axiosClient.post("/smtp/v1/contato", values).then((response) => {
          console.log(response);
        }).catch((error) => {
          console.error(error);
        });
      },
    });

  useEffect(() => {
    // use axios to request
    axiosClient
      .get("/wp/v2/posts")
      .then((response) => setPosts(response.data))
      .catch((error) => {
        setPosts([]);
        console.error(error);
      });
    axiosClient.get("/").then((response) => setSettings(response.data));
  }, []);

  return (
    <AppContext.Provider value={{ settings }}>
      <ThemeProvider theme={theme}>
        <GlobalStyles />
        <Header />
        <main>
          <p>
            Essa aplicação utiliza API Wordpress para executar suas funções
            lógicas de backend, para acessar o gerenciador de conteúdo acesse:{" "}
            <a href="/wp/wp-admin" target="_blank" rel="noreferrer">
              o painel administrativo
            </a>
            . Rota da API: {process.env.REACT_APP_API_URL}
          </p>
          <h1>Exibição de postagens</h1>
          {posts.map((post) => (
            <section key={post.id}>
              {post.title.rendered}
              <br />
              {parse(post.content.rendered)}
            </section>
          ))}
          <h1>Envio de Email Teste</h1>
          <form>
            <Input name="name" placeholder="Nome" formik={formik} />
            <Input
              name="email"
              placeholder="Email"
              type="email"
              formik={formik}
            />
            <Input name="subject" placeholder="Assunto" formik={formik} />
            <Input name="message" placeholder="Mensagem" formik={formik} />
            <Button type="button" onClick={formik.handleSubmit}>Enviar</Button>
          </form>
        </main>
      </ThemeProvider>
    </AppContext.Provider>
  );
}

export default App;
