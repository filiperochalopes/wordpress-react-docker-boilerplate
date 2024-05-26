import { theme, GlobalStyles } from "./styles";

import AppContext from "services/context";

import Header from "components/Header";
import Input from "components/Input";
import { useFormik } from "formik";
import React, { useState } from "react";
import { useEffect } from "react";
import { ThemeProvider } from "styled-components";

import axios from "axios";

function App() {
  const [user, setUser] = useState(false),
    formik = useFormik({
      initialValues: {
        name: "",
        email: "",
        subject: "",
        message: "",
      },
      onSubmit: (values) => {
        console.log(values);
      },
    });

  useEffect(() => {
    // use axios to request
    const axiosClient = axios.create({
      baseURL: process.env.REACT_APP_WP_API,
      headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
      },
    });
    axiosClient
      .get("/wp/v2/posts")
      .then((response) => console.log(response.data))
      .catch((error) => console.log(error));
  }, []);

  return (
    <AppContext.Provider value={{ user, setUser }}>
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
            . Rota da API: {process.env.REACT_APP_WP_API}
          </p>
          <h1>Exibição de postagens</h1>
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
          </form>
        </main>
      </ThemeProvider>
    </AppContext.Provider>
  );
}

export default App;
