import React from "react";
import { Routes, Route, Navigate } from "react-router-dom";
import Login from "views/Login";
import Secure from "views/Secure";

export default () => {
  return (
    <Routes>
      <Route exact path="/" element={<Navigate to="/login" replace />} />
      <Route exact path="/login" element={<Login />} />
      <Route exact path="/secure" element={<Secure />} />
    </Routes>
  );
};
