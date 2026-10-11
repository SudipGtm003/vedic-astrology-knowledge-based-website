-- Password reset OTP (email) मा चाहिने स्तम्भहरू
ALTER TABLE users
  ADD COLUMN IF NOT EXISTS otp_hash VARCHAR(255) NULL,
  ADD COLUMN IF NOT EXISTS otp_expires_at DATETIME NULL;
