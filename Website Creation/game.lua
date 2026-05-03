game.Players.PlayerAdded:Connect(function(player)
    -- leaderstats folder
    local stats = Instance.new("Folder")
    stats.Name = "leaderstats"
    stats.Parent = player

    -- Coins
    local coins = Instance.new("IntValue")
    coins.Name = "Coins"
    coins.Value = 0
    coins.Parent = stats

    -- Speed level
    local speed = Instance.new("IntValue")
    speed.Name = "SpeedLevel"
    speed.Value = 1
    speed.Parent = stats

    -- Jump level
    local jump = Instance.new("IntValue")
    jump.Name = "JumpLevel"
    jump.Value = 1
    jump.Parent = stats
end)
