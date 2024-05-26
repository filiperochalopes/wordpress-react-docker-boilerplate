import { useContext } from "react";
import Header from "./styles";
import AppContext from "services/context";

import React from "react";
export default () => {
  const { settings } = useContext(AppContext)
  return <Header>{settings?.name || "Título Wordpress"}</Header>;
};
