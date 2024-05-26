import AppContext from "services/context";

import PageTemplate from "components/PageTemplate";
import Private from "components/Private";
import React from "react";
import { useContext } from "react";

export default () => {
  const { user } = useContext(AppContext);
  return (
    <Private>
      <PageTemplate>
        <h1>Dashboard</h1>
        <p>Olá {user.email}</p>
      </PageTemplate>
    </Private>
  );
};
