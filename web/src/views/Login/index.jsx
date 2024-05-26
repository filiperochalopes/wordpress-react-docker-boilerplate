/* eslint-disable jsx-a11y/label-has-associated-control */
import MainContainer from "./styles";

import AppContext from "services/context";

import validationSchema from "./validationSchema";

import Button from "components/Button";
import Input from "components/Input";
import LoginTemplate from "components/LoginTemplate";
import { useFormik } from "formik";
import React, { useContext, useEffect } from "react";
import { useNavigate } from "react-router-dom";

const Login = () => {
  const context = useContext(AppContext),
    navigate = useNavigate(),
    formik = useFormik({
      initialValues: {
        email: "",
        password: "",
      },
      validationSchema,
      onSubmit: (values) => {
        context.setUser({
          email: values.email,
        });
        navigate("/secure");
      },
    });

  useEffect(() => {
    console.log(formik);
  }, [formik]);

  return (
    <LoginTemplate>
      <MainContainer>
        <h1>Login</h1>
        <form onSubmit={formik.handleSubmit}>
          <Input
            type="email"
            name="email"
            placeholder="Email"
            formik={formik}
          />
          <Input
            type="password"
            name="password"
            placeholder="Senha"
            formik={formik}
          />
          <Button type="submit">Entrar</Button>
        </form>
      </MainContainer>
    </LoginTemplate>
  );
};

export default Login;
