import AppContext from "services/context";

import React, { useContext } from "react";
import { Navigate } from "react-router-dom";

export default ({ children }) => {
  const { user } = useContext(AppContext);

  if (!user.email) return <Navigate to="/" replace />;
  return <section>{children}</section>;
};
